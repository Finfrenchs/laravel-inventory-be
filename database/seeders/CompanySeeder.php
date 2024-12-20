<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'PT. Jago Flutter',
            'email' => 'info@jagoflutter.com',
            'phone' => '021-12345678',
            'website' => 'https://jagoflutter.com',
            'logo' => 'https://jagoflutter.com',
            'address' => 'Jl. Contoh No. 123, Jakarta',
            'status' => 'active',
            'total_users' => 10,
            'clock_in_time' => '08:00:00',
            'clock_out_time' => '17:00:00',
            'early_clock_in_time' => 15, // dalam menit, misalnya 15 menit sebelum jam masuk
            'allow_clock_out_till' => 30, // dalam menit, misalnya 30 menit setelah jam keluar
            'self_clocking' => 1,
        ]);
    }
}
