<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SuperAdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'dashboard.view',
            'website.manage',
            'programs.manage',
            'trainers.manage',
            'trainees.manage',
            'products.manage',
            'gallery.manage',
            'events.manage',
            'success_stories.manage',
            'csr_reports.manage',
            'certificates.manage',
            'enquiries.manage',
            'settings.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::query()->firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $roles = [
            'Super Admin',
            'Admin',
            'IT Head',
            'Director View',
            'Incharge',
            'Trainer',
        ];

        foreach ($roles as $role) {
            Role::query()->firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        $superAdminRole = Role::query()->where('name', 'Super Admin')->firstOrFail();
        $superAdminRole->syncPermissions($permissions);

        $superAdmin = User::query()->updateOrCreate(
            ['email' => 'admin@skala.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ],
        );

        $superAdmin->syncRoles([$superAdminRole]);
        $superAdmin->syncPermissions($permissions);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
