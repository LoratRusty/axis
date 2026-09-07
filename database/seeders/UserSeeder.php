<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'id'        => Str::uuid(),
                'name'      => 'Admin AXIS',
                'email'     => 'admin@axis.test',
                'password'  => Hash::make('password'),
                'role'      => 'admin',
                'region'    => 'Nacional',
                'is_active' => true,
            ],
            [
                'id'        => Str::uuid(),
                'name'      => 'Coach Demo',
                'email'     => 'coach@axis.test',
                'password'  => Hash::make('password'),
                'role'      => 'coach',
                'region'    => 'Caracas',
                'is_active' => true,
            ],
            [
                'id'        => Str::uuid(),
                'name'      => 'Gerente Demo',
                'email'     => 'gerente@axis.test',
                'password'  => Hash::make('password'),
                'role'      => 'manager',
                'region'    => 'Nacional',
                'is_active' => true,
            ],
            [
                'id'        => Str::uuid(),
                'name'      => 'Juan Pérez',
                'email'     => 'trainee1@axis.test',
                'password'  => Hash::make('password'),
                'role'      => 'trainee',
                'region'    => 'Caracas',
                'is_active' => true,
            ],
            [
                'id'        => Str::uuid(),
                'name'      => 'María López',
                'email'     => 'trainee2@axis.test',
                'password'  => Hash::make('password'),
                'role'      => 'trainee',
                'region'    => 'Caracas',
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insertOrIgnore(array_merge($user, [
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]));
        }
    }
}