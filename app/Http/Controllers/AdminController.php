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

        $input['cover'] = $this->handleCoverImage($product->cover, $input['cover'] ?? null);

        $product->fill($input);
        $product->save();

        return Redirect::route('admin.products');
    }

    public function handleCoverImage(?string $productCover, ?object $inputCover)
    {
        // Imagem Vazia
        if (empty($inputCover)) {

            // Imagem vazia e produto tinha imagem salva
            if ($productCover && Storage::exists("public/{$productCover}")) {
                Storage::delete("public/{$productCover}");
            }

            $inputCover = null;
        }

        // Imagem não vazia e valida
        if (!empty($inputCover) && $inputCover->isValid()) {
            Storage::delete("public/{$productCover}" ?? '');
            $path = $inputCover->store('products_covers', 'public');
            $inputCover = $path;
        }

        return $inputCover;
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return Redirect::route('admin.products');
    }
}
