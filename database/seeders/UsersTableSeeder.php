<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bolims')->insert([
            'name' => 'Bugalter',
        ]);
        DB::table('bolims')->insert([
            'name' => 'Dekan',
        ]);
        DB::table('users')->insert([
            'name' => 'Asliddin',
            'fam' => 'Asliddin',
            'email' => 'a@jbnuu.uz',
            'bolim_id'=>'1',
            'role' => '3',
            'password' => Hash::make('a')
        ]);

        DB::table('users')->insert([
            'name' => 'Ishchi',
            'fam' => 'Ishchi',
            'bolim_id'=>'2',
            'email' => 'b1@jbnuu.uz',
            'role' => '2',
            'password' => Hash::make('a')
        ]);
        DB::table('users')->insert([
            'name' => 'Ishchi',
            'fam' => 'Ishchi',
            'email' => 'b2@jbnuu.uz',
            'bolim_id'=>'1',
            'role' => '2',
            'password' => Hash::make('a')
        ]);
        DB::table('users')->insert([
            'name' => 'User',
            'fam' => 'User',
            'email' => 'c1@jbnuu.uz',
            'bolim_id'=>'2',
            'role' => '1',
            'password' => Hash::make('a')
        ]);
        DB::table('users')->insert([
            'name' => 'User',
            'fam' => 'User',
            'email' => 'c2@jbnuu.uz',
            'role' => '1',
            'bolim_id'=>'1',
            'password' => Hash::make('a')
        ]);
    }
}
