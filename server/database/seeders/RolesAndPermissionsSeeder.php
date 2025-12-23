<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Users Management
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Medicines Management
            'view medicines',
            'create medicines',
            'edit medicines',
            'delete medicines',

            // Doses Management
            'view doses',
            'create doses',
            'edit doses',
            'delete doses',

            // Subscriptions Management
            'view subscriptions',
            'create subscriptions',
            'edit subscriptions',
            'delete subscriptions',

            // Alerts Management
            'view alerts',
            'manage alerts',

            // Companions Management
            'view companions',
            'manage companions',

            // Settings
            'manage settings',
            'view analytics',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles and assign permissions

        // Super Admin - has all permissions
        $superAdmin = Role::create(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - has most permissions except critical ones
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view users',
            'edit users',
            'view medicines',
            'create medicines',
            'edit medicines',
            'delete medicines',
            'view doses',
            'create doses',
            'edit doses',
            'delete doses',
            'view subscriptions',
            'view alerts',
            'manage alerts',
            'view companions',
            'view analytics',
        ]);

        // User - basic permissions
        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo([
            'view medicines',
            'create medicines',
            'edit medicines',
            'view doses',
            'create doses',
            'view alerts',
            'view companions',
        ]);

        // Create Super Admin user if doesn't exist
        $superAdminUser = User::firstOrCreate(
            ['email' => 'admin@mediremind.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('admin123'),
            ]
        );
        $superAdminUser->assignRole('super_admin');

        // Assign existing magic user as admin
        $magicUser = User::where('email', 'magic@app.com')->first();
        if ($magicUser && !$magicUser->hasAnyRole(['super_admin', 'admin', 'user'])) {
            $magicUser->assignRole('admin');
        }

        // Assign all other existing users the 'user' role
        $users = User::whereDoesntHave('roles')->get();
        foreach ($users as $usr) {
            $usr->assignRole('user');
        }

        $this->command->info('✅ Roles and Permissions created successfully!');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('🔐 Super Admin:');
        $this->command->info('   Email: admin@mediremind.com');
        $this->command->info('   Password: admin123');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}
