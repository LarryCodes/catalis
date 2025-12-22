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
            
            // Tenure permissions
            'view-tenures',
            'create-tenures',
            'edit-tenures',
            'delete-tenures',
            
            // Employee permissions
            'view-employees',
            'create-employees',
            'edit-employees',
            'delete-employees',
            
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

        // HR Manager - can manage employees, partners, sites, departments, tenures, payroll, attendance, recruitment, performance, reports
        $hrManager = Role::firstOrCreate(['name' => 'HR Manager']);
        $hrManager->givePermissionTo([
            // Full employee management
            'view-employees', 'create-employees', 'edit-employees', 'delete-employees',
            // Full partner management
            'view-partners', 'create-partners', 'edit-partners', 'delete-partners',
            // Full site management
            'view-sites', 'create-sites', 'edit-sites', 'delete-sites',
            // Full department management
            'view-departments', 'create-departments', 'edit-departments', 'delete-departments',
            // Full tenure management
            'view-tenures', 'create-tenures', 'edit-tenures', 'delete-tenures',
            // Payroll - view and run, but not approve
            'view-payroll', 'run-payroll', 'edit-payroll',
            // Full attendance management
            'view-attendance', 'manage-attendance', 'approve-attendance',
            // Full recruitment
            'view-recruitment', 'manage-recruitment',
            // Full performance management
            'view-performance', 'manage-performance', 'approve-appraisals',
            // Reports
            'view-reports', 'export-reports',
        ]);

        // HR Officer - view and create, limited edit/delete, no approvals
        $hrOfficer = Role::firstOrCreate(['name' => 'HR Officer']);
        $hrOfficer->givePermissionTo([
            // View and create employees only
            'view-employees', 'create-employees', 'edit-employees',
            // View partners only
            'view-partners',
            // View sites only
            'view-sites',
            // View departments only
            'view-departments',
            // View tenures only
            'view-tenures',
            // View payroll only
            'view-payroll',
            // View and manage attendance (no approve)
            'view-attendance', 'manage-attendance',
            // View recruitment only
            'view-recruitment',
            // View performance only
            'view-performance',
            // View reports only
            'view-reports',
        ]);

        // Create default Super Admin user
        $superAdminUser = User::firstOrCreate(
            ['email' => 'admin@catalis.hr'],
            [
                'name' => 'Larry Okongo',
                'password' => Hash::make('password'),
            ]
        );
        $superAdminUser->assignRole('Super Admin');
        $superAdminUser->givePermissionTo(Permission::all());

        // Create HR Manager user
        $hrManagerUser = User::firstOrCreate(
            ['email' => 'manager@catalis.hr'],
            [
                'name' => 'Jane Wanjiku',
                'password' => Hash::make('password'),
            ]
        );
        $hrManagerUser->assignRole('HR Manager');

        // Create HR Officer user
        $hrOfficerUser = User::firstOrCreate(
            ['email' => 'officer@catalis.hr'],
            [
                'name' => 'John Kamau',
                'password' => Hash::make('password'),
            ]
        );
        $hrOfficerUser->assignRole('HR Officer');

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Users created:');
        $this->command->info('  Super Admin: admin@catalis.hr / password');
        $this->command->info('  HR Manager:  manager@catalis.hr / password');
        $this->command->info('  HR Officer:  officer@catalis.hr / password');
    }
}
