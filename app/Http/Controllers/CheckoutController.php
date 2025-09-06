<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use App\Models\Order;
use Mpdf\Mpdf;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\OrderTracking;
use DateTimeZone;
use DateTime;
class CheckoutController extends Controller
{

    /**
     * Generate and stream a PDF invoice for a given order.
     */
    public function printInvoice(Order $order)
    {
        // Security Check: Ensure the user owns this order
        if (Auth::user()->customer_id !== $order->customer_id) {
            abort(403, 'Unauthorized action.');
        }

        // Load necessary related data
        $order->load('customer', 'orderDetails.product');
        
        // You can get the watermark logo from your assets
        // For mPDF to access it, we need the server path, not the web URL
        $watermarkPath = public_path('front/assets/img/page-bg.png'); 

        // Pass data to the view
        $data = [
            'order' => $order,
            'watermarkPath' => $watermarkPath
        ];

        // Render the view to HTML
        $html = view('front.checkout.invoice', $data)->render();

        // Create an instance of mPDF
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            
            
        ]);

        // Write HTML content to the PDF
        $mpdf->WriteHTML($html);

        // Output the PDF to the browser
        return $mpdf->Output('invoice-'.$order->invoice_no.'.pdf', 'I');
    }
    
         public function checkOutPage()
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Please log in to continue to checkout.');
        }

        // Reset shipping cost on page load to ensure it's re-selected
        Session::forget('checkout.shipping_cost');

        $cartData = $this->getCartTotals();
        if (empty($cartData['cartItems'])) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
        }

        $user = Auth::user();
        $customer = $user->customer;
        $billingAddress = null;
        $shippingAddress = null;

        if ($customer) {
            $billingAddress = $customer->addresses()->where('address_type', 'billing')->where('is_default', 1)->first()
                ?? $customer->addresses()->where('address_type', 'billing')->first();

            $shippingAddress = $customer->addresses()->where('address_type', 'shipping')->where('is_default', 1)->first()
                ?? $customer->addresses()->where('address_type', 'shipping')->first();
        }
        
        return view('front.checkout.checkout', array_merge(
            compact('user', 'billingAddress', 'shippingAddress'),
            $cartData
        ));
    }

    private function getCartTotals()
    {
        $cartItems = Session::get('cart', []);
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shippingCost = Session::get('checkout.shipping_cost', 0);
        $coupon = Session::get('checkout.coupon', null);
        $discount = 0;

        if ($coupon) {
            if ($coupon->type == 'fixed') {
                $discount = $coupon->value;
            } else { // Percentage
                $discount = ($subtotal * $coupon->value) / 100;
            }
        }

        $total = ($subtotal + $shippingCost) - $discount;

        return [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'discount' => $discount,
            'total' => $total,
            'coupon' => $coupon
        ];
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        // Also update shipping cost from the frontend if it's sent
        if ($request->has('shipping_cost') && is_numeric($request->shipping_cost)) {
            Session::put('checkout.shipping_cost', $request->shipping_cost);
        }

        $coupon = Coupon::where('code', $request->code)
                        ->where('status', 1)
                        ->where('expires_at', '>', now())
                        ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon code.']);
        }
        
        $subtotal = $this->getCartTotals()['subtotal'];
        if ($coupon->min_amount && $subtotal < $coupon->min_amount) {
             return response()->json(['success' => false, 'message' => "Coupon requires a minimum order of ৳{$coupon->min_amount}."]);
        }

        Session::put('checkout.coupon', $coupon);

        return response()->json([
            'success' => true, 
            'message' => 'Coupon applied successfully!',
            'totals' => $this->getCartTotals()
        ]);
    }

    public function removeCoupon(Request $request)
    {
        // Also update shipping cost from the frontend if it's sent
        if ($request->has('shipping_cost') && is_numeric($request->shipping_cost)) {
            Session::put('checkout.shipping_cost', $request->shipping_cost);
        }
        Session::forget('checkout.coupon');
        return response()->json([
            'success' => true,
            'message' => 'Coupon removed.',
            'totals' => $this->getCartTotals()
        ]);
    }

    // --- NEW METHOD TO HANDLE SHIPPING UPDATES ---
    public function updateShipping(Request $request)
    {
        $request->validate(['shipping_cost' => 'required|numeric']);
        Session::put('checkout.shipping_cost', $request->shipping_cost);
        return response()->json([
            'success' => true,
            'totals' => $this->getCartTotals()
        ]);
    }

    public function placeOrder(Request $request)
    {
        $paymentTypes = ['bkash', 'nagad', 'rocket'];
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'billing_address' => 'required|string',
            'shipping_address' => 'required|string',
            'shipping_area' => 'required|numeric',
            'payment_type' => 'required|string',
            'payment_phone' => ['required_if:payment_type,in,'.implode(',', $paymentTypes), 'nullable', 'string', 'max:20'],
            'payment_trxid' => ['required_if:payment_type,in,'.implode(',', $paymentTypes), 'nullable', 'string', 'max:255'],
            'terms' => 'accepted'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $cartData = $this->getCartTotals();
        if (empty($cartData['cartItems'])) {
            return response()->json(['success' => false, 'message' => 'Your session has expired.'], 400);
        }

        DB::beginTransaction();
        try {
            
            $orderData = [
                'customer_id' => Auth::user()->customer_id,
                'invoice_no' => 'INV-' . time() . rand(10, 99),
                'subtotal' => $cartData['subtotal'],
                'shipping_cost' => $cartData['shippingCost'],
                'discount' => $cartData['discount'],
                'total_amount' => $cartData['total'],
                'status' => 'pending',
                'delivery_type' => $request->delivery_type,
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address,
                'payment_method' => $request->payment_type,
                'payment_phone' => $request->payment_phone,
                'trxID' => $request->payment_trxid,
                'notes' => $request->note,
            ];

            if ($request->payment_type == 'cod') {
                $orderData['payment_status'] = 'unpaid';
                $orderData['total_pay'] = 0;
                $orderData['cod'] = $cartData['total'];
            } else {
                $orderData['payment_status'] = 'paid';
                $orderData['total_pay'] = $cartData['total'];
                $orderData['cod'] = 0;
            }
            
            $order = Order::create($orderData);

            foreach($cartData['cartItems'] as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['variant_id'],
                    'color' => $item['color_name'],
                    'size' => $item['size_name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();
            Session::forget(['cart', 'checkout']);


              $tz = new DateTimeZone('Asia/Dhaka');
             $dt = new DateTime('now', $tz);
             $now = $dt->format('h:i:s');

       

          $newtracking = new OrderTracking();
          $newtracking->customer_id =  $order->customer_id;
          $newtracking->tracking_number = $order->invoice_no;
          $newtracking->status = 'pending';
          $newtracking->bd_time = $now;
          $newtracking->bd_date = date('Y-m-d');
          $newtracking->save();

       
            
            // Return a success response with the new order ID
            return response()->json(['success' => true, 'order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
             \Log::error('Order Placement Failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }

     public function orderSuccess()
    {
        $orderId = session('order_id');
        if (!$orderId) {
            return redirect()->route('home.index');
        }

        $order = Order::with('orderDetails.product', 'customer')->findOrFail($orderId);

        return view('front.checkout.success', compact('order'));
    }
}
