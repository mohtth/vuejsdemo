<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Facade;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Facade\DB::table('users')->insert([
                'name' => "UtilisateurNum$i",
                "email" => "utilisateur$i@email.com",
                "password" => bcrypt('0000')
            ]);
        }
    }
}
