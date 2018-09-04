<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Thauan Santos',
            'email' => 'nero.rbr@gmail.com',
            'password' => bcrypt('vqimaha'),
        ]);

        factory(App\User::class, 20)->create();
    }
}
