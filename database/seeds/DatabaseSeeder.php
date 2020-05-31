<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Create Admin user
     */
    private function CreateAdmin()
    {
       DB::table('users')->insert([
        'nume'    => 'admin',
        'prenume' => 'admin',
        'locality_id'=> App\Locality::all()->random()->id,
        'email'   => 'admin@admin.com',
        'password' => bcrypt('password'),
           'api_token' => Str::random(60),
         ]);

       DB::table('role_users')->insert([
        'user_id' => 1,
        'role_id' => 1,
        'updated_by' => 0, // zero by default,
        ]);
    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
                    IbanTableSeeder::class,
                    LocalTableSeeder::class,
                    EcoCodTableSeeder::class,
                    RolesTableSeeder::class,
         ]);
        $this->CreateAdmin(); // Admin user trebuie sa fie primul ;-)
        $this->call(UsersTableSeeder::class);
    }

}
