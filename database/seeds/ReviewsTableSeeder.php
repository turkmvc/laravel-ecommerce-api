<?php

use Illuminate\Database\Seeder;
use App\Model\Product;
use App\Model\Review;
use App\User;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Review::class, 30)->create();
    }
}
