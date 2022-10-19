<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::query()->insert(
            [
                'name' => 'Users crud',
                'slug' => 'users-crud',
            ]);
        Permission::query()->insert(
            [
                'name' => 'Categories crud',
                'slug' => 'categories-crud',
            ]);
        Permission::query()->insert(
            [
                'name' => 'Types crud',
                'slug' => 'types-crud',
            ]);
        Permission::query()->insert(
            [
                'name' => 'Brokers crud',
                'slug' => 'brokers-crud',
            ]);
        Permission::query()->insert(
            [
                'name' => 'Brokers crud',
                'slug' => 'brokers-crud',
            ]);
        Permission::query()->insert(
            [
                'name' => 'Announcements crud',
                'slug' => 'announcements-crud',
            ]);
        Permission::query()->insert(
            [
                'name' => 'Companies crud',
                'slug' => 'companies-crud',
            ]);
        Permission::query()->insert(
            [
                'name' => 'Partners crud',
                'slug' => 'partners-crud',
            ]);
        Permission::query()->insert(
            [
                'name' => 'Agencies crud',
                'slug' => 'agencies-crud',
            ]);
        Permission::query()->insert(
            [
                'name' => 'Country crud',
                'slug' => 'countries-crud',
            ]);
        Permission::query()->insert(
            [
                'name' => 'City crud',
                'slug' => 'cities-crud',
            ]);
        Permission::query()->insert(
            [
                'name' => 'State crud',
                'slug' => 'states-crud',
            ]);
        Permission::query()->insert(
            [
                'name' => 'Constructors Crud',
                'slug' => 'constructors-crud',
            ]);
        Permission::query()->insert(
            [
                'name' => 'Agents Requests Crud',
                'slug' => 'agents-requests-crud',
            ]);
    }
}
