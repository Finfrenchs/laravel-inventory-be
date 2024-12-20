<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating a Super Admin user
        User::factory()->create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'profile_image' => 'https://via.placeholder.com/150',
            'email' => 'superadmin@admin.com',
            'password' => Hash::make('12345678'),
            'status' => 'Enable',
            'phone' => '085895226892',
            'address' => 'Surabaya, East Java, Indonesia',
            'company_id' => 1,
        ]);

        // Creating additional users
        User::factory()->create([
            'name' => 'Bahri',
            'username' => 'bahri_admin',
            'profile_image' => 'https://via.placeholder.com/150',
            'email' => 'bahri@karyawan.com',
            'password' => Hash::make('12345678'),
            'status' => 'Enable',
            'phone' => '085895226892',
            'address' => 'Surabaya, East Java, Indonesia',
            'company_id' => 1,
            'is_superadmin' => 0,
        ]);

        User::factory()->create([
            'name' => 'Kelvin',
            'username' => 'kelvin_admin',
            'profile_image' => 'https://via.placeholder.com/150',
            'email' => 'kelvin@admin.com',
            'password' => Hash::make('12345678'),
            'status' => 'Enable',
            'phone' => '085895226892',
            'address' => 'Surabaya, East Java, Indonesia',
            'company_id' => 1,
            'is_superadmin' => 0,
        ]);
    }
}
