<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;

class LandingPageController extends Controller
{
    //*************************************************    showing landing page
    public function index() {
        $products = Product::latest()->take(4)->get(); // 4 latest products
        $reviews = Review::latest()->take(3)->get();   // for review section
        return view('welcome', compact('products', 'reviews'));
    }

    // ************************************************ SHOW PRODUCTS PAGE
    /*
        *** a little pagination setting with this > php artisan vendor:publish --tag=laravel-pagination
        *** open resources/views/vendor/pagination/bootstrap-5.blade.php
        *** Remove/comment arrow sections
        *** Remove/comment "Next" button, Remove "Previous" button
        *** Its will only show page numbers then
        *** or use simplePaginate(12)
    */
    public function showProducts() {
        // $products = Product::all();
        $products = Product::latest()->paginate(12); //12 products per page
        return view('products', compact('products')); 
    }

    // ************************************************ SHOW DETAIL PAGE
    public function show(Request $request, string $id) {
        $product = Product::with('images')->findOrFail($id);
        return view('product-details', compact('product'));
    }
}
