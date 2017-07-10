<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name' => 'Neo Ighodaro',
            'email' => 'neo@hng.tech',
            'password' => bcrypt('secret'),
        ]);
    }
}
