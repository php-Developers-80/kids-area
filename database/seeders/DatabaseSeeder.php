<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //---------  insert basic user account  -----------
        $user = \App\Models\User::create([
            'name' => "admin",
            'user_name' => "admin",
            'user_type' => "admin",
            'password' => bcrypt(123456),
        ]);

        //---------  insert Settings of app  -----------

        \DB::table('settings')->insert([
            'ar_title' => "Kids area",
        ]);        // \App\Models\User::factory(10)->create();
    }
}
