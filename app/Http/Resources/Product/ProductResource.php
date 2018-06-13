<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Review\ReviewResource;
use App\Http\Resources\Review\ReviewCollection;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->detail,
            'price' => $this->price,
            'stock' => $this->stock,
            'rating' => round($this->reviews->sum('star')/ ($this->reviews->count() > 0 ? $this->reviews->count() : 1)),
            'reviews' => new ReviewCollection($this->reviews)
            // must return image 'image' => $this->featured_images,
        ];
    }
}
