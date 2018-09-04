<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($product){
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'rating' => round($product->reviews->sum('star')/ ($product->reviews->count() > 0 ? $product->reviews->count() : 1)),
                'reviews' => $product->reviews->count()
            ];
        });
    }
}
