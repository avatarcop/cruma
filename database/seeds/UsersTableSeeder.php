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
         DB::table('users')->insert([
            'id' => 1,
            'username' => 'userakbar',
            'email' => 'akbar@gmail.com',
            'name' => 'Akbar As Syidiqi',
            'password' => Hash::make('akbar123'),
            'remember_token' => '1'

        ]);
    }
}
