<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Static property to store password.
     */
    protected static $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::$password = self::$password ?? Hash::make('password');

        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => self::$password,
            'remember_token' => Str::random(10),
        ])->assignRole('admin');
    }
}
