<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
   
    public function run(): void
    {
        $superAdmin = User::where('role', 'superadmin')->first();
        if (!$superAdmin) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('Admin@123'),
                'role' => 'superadmin',
            ]);
            $this->command->info('Super Admin created successfully.');
        }else{
            $this->command->warn('Super Admin already exists. Skipping creation.');
        }
    }
}
