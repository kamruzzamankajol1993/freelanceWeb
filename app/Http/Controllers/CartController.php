<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color; // Added Color model
use App\Models\Size;   // Added Size model
class CartController extends Controller
{
    /**
     * Helper function to get cart data and totals.
     */
    private function getCartData()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        $totalItems = 0;

        foreach ($cart as $details) {
            $subtotal += $details['price'] * $details['quantity'];
            $totalItems += $details['quantity'];
        }

        return [
            'items' => $cart,
            'subtotal' => $subtotal,
            'totalItems' => $totalItems,
        ];
    }

    /**
     * Add an item to the cart.
       */
    public function addToCart(Request $request)
    {
        // --- MODIFICATION START ---
        // Updated validation to accept both variant_id and color_id
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
        ]);
        // --- MODIFICATION END ---

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $cart = session()->get('cart', []);
        
        // --- MODIFICATION START ---
        // Updated cart key to be more specific using variant_id
        $cartKey = $request->product_id . '-' . $request->variant_id . '-' . $request->size_id;
        // --- MODIFICATION END ---

        $product = Product::find($request->product_id);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += (int)$request->quantity;
        } else {
            // --- MODIFICATION START ---
            $color = $request->color_id ? Color::find($request->color_id) : null;
            $size = $request->size_id ? Size::find($request->size_id) : null;
            $variantImage = null;

            // Find the variant directly by its ID
            $variant = $request->variant_id ? ProductVariant::find($request->variant_id) : null;
            
            if ($variant && !empty($variant->variant_image)) {
                $variantImage = $variant->variant_image[0];
            }

            $image = $variantImage ?: ($product->main_image[0] ?? '');

            // Store both variant_id and color_id in the cart session
            $cart[$cartKey] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "image" => $image,
                "quantity" => (int)$request->quantity,
                "price" => $product->discount_price ?? $product->base_price,
                "variant_id" => $request->variant_id,
                "color_id" => $request->color_id,
                "color_name" => $color ? $color->name : null,
                "size_id" => $request->size_id,
                "size_name" => $size ? $size->name : null,
            ];
            // --- MODIFICATION END ---
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cartData' => $this->getCartData()
        ]);
    }

    /**
     * Get the current cart content.
     */
    public function getCartContent()
    {
        return response()->json($this->getCartData());
    }

    /**
     * Update the quantity of a cart item.
     */
    public function updateCartItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_key' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid quantity.'], 422);
        }

        $cart = session()->get('cart', []);
        $cartKey = $request->cart_key;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] = (int)$request->quantity;
            session()->put('cart', $cart);
            return response()->json(['success' => true, 'cartData' => $this->getCartData()]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found in cart.'], 404);
    }

    /**
     * Remove an item from the cart.
     */
    public function removeCartItem(Request $request)
    {
        $validator = Validator::make($request->all(), ['cart_key' => 'required|string']);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid item key.'], 422);
        }
        
        $cart = session()->get('cart', []);
        $cartKey = $request->cart_key;

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
            return response()->json(['success' => true, 'cartData' => $this->getCartData()]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found.'], 404);
    }
    
    /**
     * Clear all items from the cart.
     */
    public function clearCart()
    {
        session()->forget('cart');
        return response()->json(['success' => true, 'message' => 'Cart cleared!', 'cartData' => $this->getCartData()]);
    }

    public function show()
    {
        return view('front.cart.cart'); // Make sure this path is correct for your cart.blade.php
    }
}