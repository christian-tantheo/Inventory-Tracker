<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'User', 'guard_name' => 'web']);

        // Assign Admin role to super@admin.com
        $adminUser = User::where('email', 'super@admin.com')->first();
        if ($adminUser && !$adminUser->hasRole('Admin')) {
            $adminUser->assignRole($adminRole);
        }

        // Assign User role to other users without roles
        $usersWithoutRoles = User::doesntHave('roles')->get();
        foreach ($usersWithoutRoles as $user) {
            $user->assignRole($userRole);
        }
    }
}
