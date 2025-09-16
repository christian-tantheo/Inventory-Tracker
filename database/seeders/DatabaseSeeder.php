<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(RoleSeeder::class);

        $adminUser = User::updateOrCreate(
            ['email' => 'super@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('admin123'),
            ]
        );

        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole && !$adminUser->hasRole('Admin')) {
            $adminUser->assignRole($adminRole);
        }
    }
}
