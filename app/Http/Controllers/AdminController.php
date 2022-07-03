<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('admin.products', compact('products'));
    }

    public function create()
    {

        return view('admin.product_create');
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => 'required|string|min:3|max:100|unique:products',
            'price' => 'string|required',
            'stock' => 'integer|nullable',
            'description' => 'string|required',
            'cover' => [
                'file',
                'nullable',
                'mimes:jpg,png'
            ],
        ]);

        $input['slug'] = Str::slug($input['name']);

        if (!empty($input['cover']) && $input['cover']->isValid()) {
            $path = $input['cover']->store('products_covers', 'public');
            $input['cover'] = $path;
        }

        Product::create($input);

        return Redirect::route('admin.products');
    }

    public function edit()
    {

        return view('admin.product_edit');
    }

    public function update()
    {
        echo 'Update';
    }
}
