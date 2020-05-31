<?php

use Illuminate\Database\Seeder;

class RoleUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($user_id, $role_id, $updated_by)
    {
        $role = DB::table('role_users');

        $role->insert([
             'user_id' => $user_id,
             'role_id' => $role_id,
             'updated_by' => $updated_by,
         ]);
    }
}
