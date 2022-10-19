<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->insert(
            [
                'name' => 'Super Admin',
                'slug' => 'super_admin',
            ]);
        Role::query()->insert(
            [
                'name' => 'Admin',
                'slug' => 'admin',
            ]);
        Role::query()->insert(
            [
                'name' => 'Manager',
                'slug' => 'manager',
            ]);
        Role::query()->insert(
            [
                'name' => 'Broker',
                'slug' => 'broker',
            ]);
        Role::query()->insert(
            [
                'name' => 'User',
                'slug' => 'user',
            ]);
    }
}
