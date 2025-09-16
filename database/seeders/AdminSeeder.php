<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Istrator',
            'first_name' => 'Admin',
            'last_name' => 'Istrator',
            'username' => '100011',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'), // Use a secure password
            'mobile' => '872.315.2266',
            'gender' => 'Female',
            'date_of_birth' => '1971-06-22',
            'email_verified_at' => now(),
            'avatar' => 'img/default-avatar.jpg',
            'status' => 1,
        ]);
    }
}
