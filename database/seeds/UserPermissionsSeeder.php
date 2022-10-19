<?php

use Illuminate\Database\Seeder;

class UserPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('user_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('user_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 2
        ]);
        \Illuminate\Support\Facades\DB::table('user_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 3
        ]);
        \Illuminate\Support\Facades\DB::table('user_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 4
        ]);
        \Illuminate\Support\Facades\DB::table('user_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 5
        ]);
        \Illuminate\Support\Facades\DB::table('user_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 6
        ]);
        \Illuminate\Support\Facades\DB::table('user_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 7
        ]);
        \Illuminate\Support\Facades\DB::table('user_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 8
        ]);
        \Illuminate\Support\Facades\DB::table('user_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 9
        ]);
        \Illuminate\Support\Facades\DB::table('user_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 10
        ]);
        \Illuminate\Support\Facades\DB::table('user_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 11
        ]);
    }
}
