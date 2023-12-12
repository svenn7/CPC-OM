<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([

        //admin
        [
            'id_no'=>'7777',
            'password'=> Hash::make('Dine'),
            'role'=> 'admin',
            'stud_id'=> null,
        ],

        ]);
    }
}
