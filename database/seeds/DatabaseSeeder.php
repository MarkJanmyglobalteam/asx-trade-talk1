<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
         User::create(['first_name' => 'Administrator', 'last_name' => '', 'email' => 'superadmin@mailinator.com', 'password' => Hash::make('12345678'), 'activated' => 1]);
    }
}
