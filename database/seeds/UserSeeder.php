<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->insert([
            'first_name' => 'Armen',
            'last_name' => 'Khachatryan',
            'email' => 'xacharm97@gmail.com',
            'phone' => '77777777',
            'password' => Hash::make('123456789'),
        ]);
    }
}
