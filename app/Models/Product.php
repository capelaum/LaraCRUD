<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'cover',
        'stock',
        'description'
    ];

    public static function getProductCoverPath(Product $product)
    {
        if ($product->cover) {
            $isPlaceholder = Str::contains($product->cover, 'https://via.placeholder.com');

            $cover = $isPlaceholder ?
                $product->cover :
                Storage::disk('public')->url($product->cover);
        }

        if (!$product->cover) {
            $cover = "https://dummyimage.com/800x450";
        }

        return $cover;
    }
}
