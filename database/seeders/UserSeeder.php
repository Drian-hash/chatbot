<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'User 1',
            'username' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('12345678'),
            'status' => 'active',
        ]);
    }
}
