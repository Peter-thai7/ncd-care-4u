<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $roles = [
            'system-admin',
            'sub-admin',
            'doctor',
            'nutritionist',
            'physiotherapist',
            'nurse',
            'laboratory',
            'patient',
            'observer',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@ncdcare4u.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('NcdAdmin2024'),
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('system-admin');

        $this->command->info('Successfully seeded 9 Roles and System Admin!');
    }
}
