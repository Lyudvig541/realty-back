<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
//use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function Permission()
    {
        $super_admin_permission = Permission::query()->where('slug','create-tasks')->first();
        $admin_permission = Permission::query()->where('slug','create-users')->first();
        $manager_permission = Permission::query()->where('slug','create-tasks')->first();
        $broker_permission = Permission::query()->where('slug','create-tasks')->first();
        $user_permission = Permission::query()->where('slug', 'edit-users')->first();

        //RoleTableSeeder.php
        $super_admin_role = new Role();
        $super_admin_role->slug = 'super_admin';
        $super_admin_role->name = 'Super Admin';
        $super_admin_role->save();
        $super_admin_role->permissions()->attach($super_admin_permission);

        $admin_role = new Role();
        $admin_role->slug = 'admin';
        $admin_role->name = 'Admin';
        $admin_role->save();
        $admin_role->permissions()->attach($admin_permission);

        $manager_role = new Role();
        $manager_role->slug = 'manager';
        $manager_role->name = 'Manager';
        $manager_role->save();
        $manager_role->permissions()->attach($manager_permission);

        $broker_role = new Role();
        $broker_role->slug = 'broker';
        $broker_role->name = 'Broker';
        $broker_role->save();
        $broker_role->permissions()->attach($broker_permission);

        $user_role = new Role();
        $user_role->slug = 'user';
        $user_role->name = 'User';
        $user_role->save();
        $user_role->permissions()->attach($user_permission);

        $super_admin_role = Role::query()->where('slug','super_admin')->first();
        $admin_role = Role::query()->where('slug','admin')->first();
        $manager_role = Role::query()->where('slug', 'manager')->first();
        $broker_role = Role::query()->where('slug', 'broker')->first();

        $controllData = new Permission();
        $controllData->slug = 'controll-data';
        $controllData->name = 'Controll data';
        $controllData->save();
        $controllData->roles()->attach($super_admin_role);

        $editUsers = new Permission();
        $editUsers->slug = 'edit-users';
        $editUsers->name = 'Edit Users';
        $editUsers->save();
        $editUsers->roles()->attach($admin_role);

        $editHouse = new Permission();
        $editHouse->slug = 'edit-houes';
        $editHouse->name = 'Edit Houes';
        $editHouse->save();
        $editHouse->roles()->attach($manager_role);

        $editrealty = new Permission();
        $editrealty->slug = 'edit-realty';
        $editrealty->name = 'Edit Realty';
        $editrealty->save();
        $editrealty->roles()->attach($broker_role);

        $changerealty = new Permission();
        $changerealty->slug = 'edit-realty';
        $changerealty->name = 'Edit Realty';
        $changerealty->save();
        $changerealty->roles()->attach($broker_role);

        $super_admin_role = Role::query()->where('slug','super_admin')->first();
        $admin_role = Role::query()->where('slug', 'admin')->first();
        $manager_role = Role::query()->where('slug', 'manager')->first();
        $broker_role = Role::query()->where('slug', 'broker')->first();
//        $user_role = Role::query()->where('slug', 'user')->first();
//        $dev_perm = Permission::query()->where('slug','create-tasks')->first();
//        $admin_perm = Permission::query()->where('slug','edit-users')->first();

        $super_admin = new User();
        $super_admin->name = 'Armen Super Admin';
        $super_admin->email = 'armensuperadmin@gmail.com';
        $super_admin->password = bcrypt('armen1997');
        $super_admin->save();
        $super_admin->roles()->attach($super_admin_role);
        $super_admin->permissions()->attach($super_admin_role);

        $admin = new User();
        $admin->name = 'Armen Admin';
        $admin->email = 'armenadmin@gmail.com';
        $admin->password = bcrypt('armen1997');
        $admin->save();
        $admin->roles()->attach($admin_role);
        $admin->permissions()->attach($admin_role);

        $manager = new User();
        $manager->name = 'Armen Admin';
        $manager->email = 'armenadmin@gmail.com';
        $manager->password = bcrypt('armen1997');
        $manager->save();
        $manager->roles()->attach($manager_role);
        $manager->permissions()->attach($manager_role);


        $broker = new User();
        $broker->name = 'Armen Broker';
        $broker->email = 'armenbroker@gmail.com';
        $broker->password = bcrypt('armen1997');
        $broker->save();
        $broker->roles()->attach($broker_role);
        $broker->permissions()->attach($broker_role);

//        $user = new User();
//        $user->name = 'Armen Broker';
//        $user->email = 'armenbroker@gmail.com';
//        $user->password = bcrypt('armen1997');
//        $user->save();
//        $user->roles()->attach($user_role);
//        $user->permissions()->attach($user_role);

        return redirect()->back();
    }
}
