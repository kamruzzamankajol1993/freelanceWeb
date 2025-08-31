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
class FrontController extends Controller
{
       public function index(){

        $sliders = MainSlider::where('status', 1)->latest()->get();

        $showcaseProducts = Product::with('category')
                                ->where('status', 1)
                                ->inRandomOrder()
                                ->limit(6)
                                ->get();

        $latestProducts = Product::where('status', 1)->latest()->limit(6)->get();

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
            ->take(5)
            ->get();

                    $offerBanners = OfferBanner::where('status', 1)->get()->keyBy('banner_type');

        // Pass all data to the view
        return view('front.index', compact(
            'sliders', 
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


}
