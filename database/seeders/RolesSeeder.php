<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- POS Permissions ---
        $posPermissions = [
            'pos.view',
            'pos.create-sale',
            'pos.manage-products',
            'pos.manage-categories',
            'pos.manage-customers',
            'pos.manage-suppliers',
            'pos.manage-inventory',
            'pos.reports',
            'pos.refunds',
            'pos.discounts',
        ];

        // --- HRM Permissions ---
        $hrmPermissions = [
            'hrm.view',
            'hrm.manage-employees',
            'hrm.manage-departments',
            'hrm.manage-attendance',
            'hrm.manage-leaves',
            'hrm.manage-payroll',
            'hrm.manage-recruitment',
            'hrm.reports',
        ];

        // --- System Permissions ---
        $systemPermissions = [
            'system.manage-users',
            'system.manage-roles',
            'system.settings',
        ];

        $allPermissions = array_merge($posPermissions, $hrmPermissions, $systemPermissions);

        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // --- Create Roles & Assign Permissions ---

        // Super Admin — all permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->syncPermissions(Permission::all());

        // Manager — all POS + all HRM
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $manager->syncPermissions(array_merge($posPermissions, $hrmPermissions));

        // Cashier — POS only (limited)
        $cashier = Role::firstOrCreate(['name' => 'cashier']);
        $cashier->syncPermissions([
            'pos.view',
            'pos.create-sale',
            'pos.manage-customers',
            'pos.discounts',
            'pos.refunds',
        ]);

        // HR Manager — all HRM permissions
        $hrManager = Role::firstOrCreate(['name' => 'hr-manager']);
        $hrManager->syncPermissions($hrmPermissions);

        // Employee — view only
        $employee = Role::firstOrCreate(['name' => 'employee']);
        $employee->syncPermissions([
            'hrm.view',
        ]);

        // --- Create Default Super Admin User ---
        $user = User::firstOrCreate(
            ['email' => 'admin@pos.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
        $user->assignRole('super-admin');

        $this->command->info('Roles, permissions, and default admin user created successfully.');
    }
}
