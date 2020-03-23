<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run seeds for users table.
     *
     * @return void
     */
    public function run()
    {
        if(User::get()->count() < 100)
            factory(User::class, 100)->create();
    }
}
