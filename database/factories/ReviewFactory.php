<?php

use Faker\Generator as Faker;
use App\Model\Review;
use App\User;
use App\Model\Product;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'review' => $faker->sentence(10),
        'star' => $faker->numberBetween(1, 5),
        'customer_id' => function () {
            return User::all()->random();
        },
        'product_id' => function () {
            return Product::all()->random();
        }
    ];
});
