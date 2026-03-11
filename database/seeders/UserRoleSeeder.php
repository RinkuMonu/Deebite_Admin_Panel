<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\VendorDetail;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('12345678');
        $roles = ['user', 'vendor', 'delivery'];

        foreach ($roles as $role) {
            for ($i = 1; $i <= 10; $i++) {
                
                // Jaipur ke aas-paas random coordinates generate karo
                // Latitude: 26.8500 to 26.9500
                // Longitude: 75.7500 to 75.8500
                $lat = 26.8500 + (mt_rand() / mt_getrandmax()) * (26.9500 - 26.8500);
                $lng = 75.7500 + (mt_rand() / mt_getrandmax()) * (75.8500 - 75.7500);

                $user = User::create([
                    'name' => ucfirst($role) . ' ' . $i,
                    'email' => $role . $i . '@gmail.com',
                    'password' => $password,
                    'role' => $role,
                    'number' => '98765432' . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'address' => 'Location area ' . $i . ', Jaipur',
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'is_active' => true,
                ]);

                if ($role === 'vendor') {
                    VendorDetail::create([
                        'user_id' => $user->id,
                        'shop_name' => 'Shop of ' . $user->name,
                        'document_type' => 'FSSAI',
                        'fssai_number' => 'FSSAI' . rand(10000, 99999),
                    ]);
                }
            }
        }
        $this->command->info('Database seeded with Jaipur location data!');
    }
}