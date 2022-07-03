<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductFormRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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

    public function store(StoreProductFormRequest $request)
    {
        $input = $request->all();

        $input['slug'] = Str::slug($input['name']);

        if (!empty($input['cover']) && $input['cover']->isValid()) {
            $path = $input['cover']->store('products_covers', 'public');
            $input['cover'] = $path;
        }

        Product::create($input);

        return Redirect::route('admin.products');
    }

    public function edit(Product $product)
    {
        return view('admin.product_edit', compact('product'));
    }

    public function update(StoreProductFormRequest $request, Product $product)
    {
        $input = $request->validated();

        if (!empty($input['cover']) && $input['cover']->isValid()) {
            Storage::delete("public/{$product->cover}" ?? '');
            $path = $input['cover']->store('products_covers', 'public');
            $input['cover'] = $path;
        }

        $product->fill($input);
        $product->save();

        return Redirect::route('admin.products');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return Redirect::route('admin.products');
    }

    public function destroyImage(Product $product)
    {
        Storage::delete("public/{$product->cover}" ?? '');
        $product->cover = null;
        $product->save();

        return Redirect::back();
    }
}
