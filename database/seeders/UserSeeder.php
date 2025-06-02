<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {

        $plainPassword = Str::random(16);

        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make($plainPassword),
        ]);

        echo "\nAdmin login:\n";
        echo "Email: admin@example.com\n";
        echo "Password: {$plainPassword}\n";
    }
}
