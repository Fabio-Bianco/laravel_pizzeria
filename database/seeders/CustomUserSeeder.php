<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'prova1234@mailchef.it'],
            [
                'name' => 'Admin Personalizzato',
                'password' => Hash::make('Ciaopassword'),
                'email_verified_at' => now(),
            ]
        );
    }
}
