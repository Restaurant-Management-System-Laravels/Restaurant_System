<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // change this if you like
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'), // change this too
                'role' => 'admin',
                'is_approved' => true,
            ]
        );
    }
}
