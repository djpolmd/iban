<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker      =  \Faker\Factory::create();
        $role_seed  =  new RoleUsersTableSeeder();
        $locality   =  App\Locality::all();

      for($i=2; $i<37; ++$i)
        {
          $locality_id = $locality->random()->id;

          DB::table('users')->insert([
              'nume'     =>  $faker->firstName,
              'prenume'  =>  $faker->lastName,
              'locality_id' =>  $locality_id,
              'email'    =>  $faker->email,
              'password' => bcrypt('password'),
              'api_token' => Str::random(60),
          ]);

            $role_seed  =  new RoleUsersTableSeeder();
            //role_id : 2 - opeartor / 3 - operator_raion
            $role_seed->run($i, 3,0);
        }
    }

}
