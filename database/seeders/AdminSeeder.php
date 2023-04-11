<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::withoutEvents(function () {
            User::create([
                'name' => 'Hiba',
                'email' => 'admin@admin.com',
                'role' => 'super-admin',
                'password' => '123456789',
            ]);
        });
    }
}
