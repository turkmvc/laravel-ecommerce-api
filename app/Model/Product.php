<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'detail',
        'price',
        'stock',
        'featured_image_id',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }
}
