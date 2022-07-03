<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $product->cover = Product::getProductCoverPath($product);
        }

        return view('home', [
            'products' => $products
        ]);
    }
}
