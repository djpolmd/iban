<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = DB::table('roles');

        $roles->insert([
             'role_name'    => 'admin',
             'role_enabled' => 1,
             'role_permissions' => 'edit-settings'
         ]);

        $roles->insert([
            'role_name'    => 'operator',
            'role_enabled' => 1,
            'role_permissions' => 'update-post'
        ]);

        $roles->insert([
            'role_name'    => 'operator_raion',
            'role_enabled' => 1,
            'role_permissions' => 'update-post'
        ]);
    }
}
