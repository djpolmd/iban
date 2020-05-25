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
        $faker = \Faker\Factory::create();

        DB::table('users')->insert([
            'nume' => $faker->firstName,
            'prenume' =>  $faker->lastName,
            'email' => $faker->email,
            'password' => bcrypt('password'),
        ]);
    }
}
