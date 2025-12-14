<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Employee permissions
            'view-employees',
            'create-employees',
            'edit-employees',
            'delete-employees',
            
            // Partner/Client permissions
            'view-partners',
            'create-partners',
            'edit-partners',
            'delete-partners',
            
            // Site permissions
            'view-sites',
            'create-sites',
            'edit-sites',
            'delete-sites',
            
            // Department permissions
            'view-departments',
            'create-departments',
            'edit-departments',
            'delete-departments',
            
            // Payroll permissions
            'view-payroll',
            'run-payroll',
            'edit-payroll',
            'approve-payroll',
            
            // Time & Attendance permissions
            'view-attendance',
            'manage-attendance',
            'approve-attendance',
            
            // Talent Acquisition permissions
            'view-recruitment',
            'manage-recruitment',
            
            // Performance permissions
            'view-performance',
            'manage-performance',
            'approve-appraisals',
            
            // Reports & Analytics permissions
            'view-reports',
            'export-reports',
            
            // System permissions
            'manage-users',
            'manage-roles',
            'manage-settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Super Admin - full access
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Create default Super Admin user
        $user = User::firstOrCreate(
            ['email' => 'admin@catalis.hr'],
            [
                'name' => 'Larry Okongo',
                'password' => Hash::make('password'),
            ]
        );
        $user->assignRole('Super Admin');
        $user->givePermissionTo(Permission::all()); // Assign all permissions directly to user

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Default admin user created: admin@catalis.hr / password');
        $this->command->info('Super Admin has all permissions assigned directly and through role.');
    }
}
