<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ Create Admin role
        $adminRole = Role::updateOrCreate(
            ['name' => 'Admin']
        );

        // ✅ Emails of initial admins
        $adminEmails = [
            'wlsfernandes@gmail.com',
            'drlizrios@gmail.com',
        ];

        // ✅ Attach role to users
        User::whereIn('email', $adminEmails)->get()->each(function ($user) use ($adminRole) {
            $user->roles()->syncWithoutDetaching([$adminRole->id]);
        });
    }
}
