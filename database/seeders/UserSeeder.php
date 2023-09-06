<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(20)->create();

        User::create([
            'name' => 'M. Kelvin Madrianto Fahendra',
            'email' => 'kelvin@gmail.com',
            'email_verified_at' => now(),
            'role' => 'admin',
            'phone' => '021398765436',
            'bio' => 'Flutter Developer',
            'password' => Hash::make('Admin01'),
        ]);

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'role' => 'superadmin',
            'phone' => '031398765437',
            'bio' => 'Fullstack Developer',
            'password' => Hash::make('Qwerty0987'),
        ]);
    }
}
