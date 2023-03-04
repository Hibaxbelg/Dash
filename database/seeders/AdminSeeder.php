<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; //importer class DB
use Illuminate\Support\Facades\Hash; //importer class Hash
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            'name'=> 'Hiba',
            'email'=> 'admin@admin.com',
            'role'=> 'admin',
            'password'=> Hash::make('123456789')
        ]
        );
    }
}
