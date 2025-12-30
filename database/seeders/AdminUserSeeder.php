<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'wlsfernandes@gmail.com'],
            [
                'name' => 'Administrator',
                'email_verified_at' => now(),
                'password' => Hash::make('administrator'), // never store plain passwords!
            ]
        );


        $this->command->info('✅ Admin users created:');
        $this->command->info(' - wlsfernandes@gmail.com / administrator');
        $this->command->info(' - drlizrios@gmail.com / administrator');
    }
}
