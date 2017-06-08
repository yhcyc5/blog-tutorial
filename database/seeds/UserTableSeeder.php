<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        User::create([
            'name' => '123',
            'email'    => '123@123',
            'password' => bcrypt('123'),
            'status' => true,
            'confirmed_code' => null,
        ]);
    }

}
