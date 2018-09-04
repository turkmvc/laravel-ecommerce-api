<?php

use Faker\Generator as Faker;
use App\Model\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'detail' => $faker->sentence(10, true),
        'price' => $faker->randomFloat(2, 10, 100),
        'stock' => $faker->numberBetween(2, 100)
    ];
});
