<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run seeds for users table.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Add dummy user.
         */
        User::firstOrCreate([
            'name' => 'test',
            'email' => 'test@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make(123456),
            'remember_token' => Str::random(10),
        ]);

        /**
         * Add dummy admin.
         */
        User::firstOrCreate([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make(123456),
            'remember_token' => Str::random(10),
        ]);

        if(User::get()->count() < 100)
            factory(User::class, 100)->create();

    }
}
