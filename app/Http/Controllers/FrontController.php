<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MainSlider; 
use App\Models\Product;
use App\Models\OfferProduct; // Import the OfferProduct model
use Carbon\Carbon;
use App\Models\Category; // Import the Category model
use Illuminate\Support\Str; // Import the Str facade for text limiting
use App\Models\OfferBanner;
use DB;
use App\Models\Order;
class FrontController extends Controller
{
       public function index(){


        $categoryListNew = Category::limit(6)->get();

        $sliders = MainSlider::where('status', 1)->latest()->get();

        $showcaseProducts = Product::with('category')
                                ->where('status', 1)
                                ->inRandomOrder()
                                ->limit(6)
                                ->get();

        $latestProducts = Product::where('status', 1)->latest()->limit(24)->get();

        $today = Carbon::now();
        $offerProducts = OfferProduct::with('product.category')
            ->where('status', 1)
            ->where('offer_start_date', '<=', $today)
            ->where('offer_end_date', '>=', $today)
            ->latest()
            ->take(3)
            ->get();

        // Fetch 4 random products that have a discount price
        $discountedProducts = Product::with('category')
            ->where('status', 1)
            ->whereNotNull('discount_price')
            ->where('discount_price', '>', 0)
            ->inRandomOrder()
            ->limit(4)
            ->get();

              $tabCategories = Category::where('status', 1)
            ->whereHas('products', function ($query) {
                $query->where('status', 1);
            })
            ->with(['products' => function ($query) {
                $query->where('status', 1)->latest()->take(12);
            }])
           // ->take(5)
            ->get();

                    $offerBanners = OfferBanner::where('status', 1)->get()->keyBy('banner_type');

        // Pass all data to the view
        return view('front.index', compact(
            'sliders', 
            'categoryListNew',
            'showcaseProducts', 
            'latestProducts', 
            'offerProducts',
            'discountedProducts',
            'tabCategories',
            'offerBanners'
        ));
    }

     public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)
                           ->where('status', 1)
                           ->latest()
                           ->paginate(12); // Paginate with 12 products per page

        // This handles both the initial page load and AJAX requests
        if (request()->ajax()) {
            $view = view('front.partials._product_grid', compact('products'))->render();
            return response()->json(['html' => $view]);
        }

        return view('front.category.show', compact('category', 'products'));
    }

     public function shop()
    {
        $products = Product::where('status', 1)->latest()->paginate(5);

        // This handles both the initial page load and AJAX requests for infinite scroll
        if (request()->ajax()) {
            $view = view('front.partials._product_grid', compact('products'))->render();
            return response()->json(['html' => $view]);
        }

        return view('front.shop.show', compact('products'));
    }


    public function product($slug)
    {
        // Fetch the main product with all its relationships
        $product = Product::where('slug', $slug)
            ->where('status', 1)
            ->with([
                'category',
                'brand',
                'variants.color', // Load variants and their associated color
                'assignChart.entries'
            ])
            ->firstOrFail();

        // Fetch related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('front.product.product_detail', compact('product', 'relatedProducts'));
    }

     public function quickView($id)
    {
        $product = Product::with(['variants.color'])->findOrFail($id);

        // The 'detailed_sizes' accessor on the ProductVariant model will automatically be included
        // when the model is converted to JSON, which is perfect for our needs.
        return response()->json($product);
    }

     public function searchProducts(Request $request)
    {

        

        $query = $request->get('query');

        if ($query) {
            $products = Product::where('name', 'LIKE', "%{$query}%")
                               ->orWhere('product_code', 'LIKE', "%{$query}%")
                               ->select('name', 'slug', 'main_image') // Select only needed fields
                               ->limit(5) // Limit the number of results
                               ->get();
            
            // Modify image paths to be absolute URLs
            $products->each(function($product) {
                if (!empty($product->main_image)) {
                    $frontEndData = DB::table('system_information')->first();
        $front_ins_url = $frontEndData->main_url.'public/uploads/';
                    $product->main_image = $front_ins_url.$product->main_image[0];
                } else {
                    // Provide a placeholder if no image exists
                    $product->main_image = 'https://placehold.co/50x50?text=No+Img';
                }
            });

            return response()->json($products);
        }

        return response()->json([]);
    }


    public function aboutUs(){

        return view('front.aboutus');
    }

    public function support(){

        return view('front.support');

    }

    public function orderTracking(){

        return view('front.tracking');

    }

    /**
     * Handle the AJAX request to track an order.
     */
    public function trackOrder(Request $request)
    {
        $request->validate(['invoice_no' => 'required|string']);

        $order = Order::where('invoice_no', $request->invoice_no)
                      ->withCount('orderDetails') // Efficiently count items
                      ->first();

        if ($order) {
            // Format the date for better display
            $order->formatted_created_at = $order->created_at->format('d M Y');
            return response()->json($order);
        }

        return response()->json(['error' => 'Order not found. Please check the order number and try again.'], 404);
    }


}
