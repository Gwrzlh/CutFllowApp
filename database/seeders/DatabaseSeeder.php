<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Roles
        $adminRole = Role::create(['name' => 'Admin', 'slug' => 'admin']);
        $kasirRole = Role::create(['name' => 'Kasir', 'slug' => 'kasir']);
        $ownerRole = Role::create(['name' => 'Owner', 'slug' => 'owner']);

        // 2. Buat User Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@cutflow.id',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        // 3. Buat User Kasir
        User::create([
            'name' => 'Kasir Utama',
            'email' => 'kasir@cutflow.id',
            'password' => Hash::make('password'),
            'role_id' => $kasirRole->id,
        ]);

        // 4. Buat User Owner
        User::create([
            'name' => 'Owner Cutflow',
            'email' => 'owner@cutflow.id',
            'password' => Hash::make('password'),
            'role_id' => $ownerRole->id,
        ]);
    }
}
