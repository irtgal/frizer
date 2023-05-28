<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Type;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create the first user and set admin_id
        $adminUser = [
            'name' => 'Test',
            'slug' => 'test',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $existingAdminUser = User::where('email', $adminUser['email'])->first();

        if (!$existingAdminUser) {
            $adminUser = User::create($adminUser);
            $adminUserId = $adminUser->id;

            // Additional type classes
            $types = [
                [
                    'name' => 'Moško striženje', // Men's haircut
                    'description' => '',
                    'price' => 10.00,
                    'admin_id' => $adminUserId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Žensko striženje', // Women's haircut
                    'description' => '',
                    'price' => 15.00,
                    'admin_id' => $adminUserId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Barvanje las', // Hair coloring
                    'description' => '',
                    'price' => 20.00,
                    'admin_id' => $adminUserId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // Add more type classes here
            ];

            foreach ($types as $type) {
                $existingType = Type::where('name', $type['name'])->first();

                if (!$existingType) {
                    Type::create($type);
                }
            }
        }
    }
}
