<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = Hash::make('12345678');
        $now = now()->format('Y-m-d H:i:s');
        Role::insert([
            ['name' => 'Super Admin', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Admin', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'User', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now]
        ]);
        Permission::insert([
            ['name' => 'Read', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Write', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
        ]);

        User::insert([
            ['name' => 'Tech Enfield', 'phone_number' => '9810000000', 'email' => 'info@techenfield.com', 'password' => $password, 'role_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Bibek Thapa Magar', 'phone_number' => '9809101575', 'email' => 'bibek.thapa0521@gmail.com', 'password' => $password, 'role_id' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Suresh Thapa', 'phone_number' => '9855065429', 'email' => 'sureshthapa@gmail.com', 'password' => $password, 'role_id' => 3, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
