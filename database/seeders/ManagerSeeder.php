<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\password;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = 'password';
        $hashedPassword = Hash::make($password);

        $user = User::create([
            'name' => 'manager',
            'email' => 'manager@gmail.com',
            'email_verified_at' => now(),
            'password' => $hashedPassword,
        ]);
        $user->assignRole('user', 'manager');

    }
}
