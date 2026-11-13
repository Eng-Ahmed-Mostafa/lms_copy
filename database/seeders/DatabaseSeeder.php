<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);

        $user =User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'ahmedmstafa419@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('super-admin');
    }
}
