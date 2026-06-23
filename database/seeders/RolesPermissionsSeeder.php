<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesPermissionsSeeder extends Seeder
{
    public function run()
    {
        // ---------------------------------------------------------------
        // 1. All permissions grouped by menu
        // ---------------------------------------------------------------
        $permissions = [

            // --- Dashboard ---
            ['group' => 'Dashboard',       'name' => 'View Dashboard',            'slug' => 'dashboard.view'],

            // --- Products ---
            ['group' => 'Products',        'name' => 'View Products',             'slug' => 'products.view'],
            ['group' => 'Products',        'name' => 'Create Product',            'slug' => 'products.create'],
            ['group' => 'Products',        'name' => 'Edit Product',              'slug' => 'products.edit'],
            ['group' => 'Products',        'name' => 'Delete Product',            'slug' => 'products.delete'],

            // --- Categories ---
            ['group' => 'Categories',      'name' => 'View Categories',           'slug' => 'categories.view'],
            ['group' => 'Categories',      'name' => 'Create Category',           'slug' => 'categories.create'],
            ['group' => 'Categories',      'name' => 'Edit Category',             'slug' => 'categories.edit'],
            ['group' => 'Categories',      'name' => 'Delete Category',           'slug' => 'categories.delete'],

            // --- Sliders ---
            ['group' => 'Sliders',         'name' => 'View Sliders',              'slug' => 'sliders.view'],
            ['group' => 'Sliders',         'name' => 'Create Slider',             'slug' => 'sliders.create'],
            ['group' => 'Sliders',         'name' => 'Edit Slider',               'slug' => 'sliders.edit'],
            ['group' => 'Sliders',         'name' => 'Delete Slider',             'slug' => 'sliders.delete'],

            // --- Orders ---
            ['group' => 'Orders',          'name' => 'View Orders',               'slug' => 'orders.view'],
            ['group' => 'Orders',          'name' => 'View Order Detail',         'slug' => 'orders.view-detail'],
            ['group' => 'Orders',          'name' => 'Update Order Status',       'slug' => 'orders.update-status'],
            ['group' => 'Orders',          'name' => 'Delete Order',              'slug' => 'orders.delete'],

            // --- Contacts ---
            ['group' => 'Contacts',        'name' => 'View Contact Messages',     'slug' => 'contacts.view'],
            ['group' => 'Contacts',        'name' => 'Delete Contact Message',    'slug' => 'contacts.delete'],

            // --- Feedback / Testimonials ---
            ['group' => 'Feedback',        'name' => 'View Feedback',             'slug' => 'feedback.view'],
            ['group' => 'Feedback',        'name' => 'Create Feedback',           'slug' => 'feedback.create'],
            ['group' => 'Feedback',        'name' => 'Edit Feedback',             'slug' => 'feedback.edit'],
            ['group' => 'Feedback',        'name' => 'Delete Feedback',           'slug' => 'feedback.delete'],

            // --- Pages (About Page) ---
            ['group' => 'Pages',           'name' => 'Edit About Page',           'slug' => 'pages.edit'],

            // --- Company Profile ---
            ['group' => 'Company Profile', 'name' => 'View Company Profile',      'slug' => 'company-profile.view'],
            ['group' => 'Company Profile', 'name' => 'Create Company Profile',    'slug' => 'company-profile.create'],
            ['group' => 'Company Profile', 'name' => 'Edit Company Profile',      'slug' => 'company-profile.edit'],

            // --- User Management ---
            ['group' => 'Users',           'name' => 'View Users',                'slug' => 'users.view'],
            ['group' => 'Users',           'name' => 'Create User',               'slug' => 'users.create'],
            ['group' => 'Users',           'name' => 'Edit User',                 'slug' => 'users.edit'],
            ['group' => 'Users',           'name' => 'Delete User',               'slug' => 'users.delete'],

            // --- Role Management ---
            ['group' => 'Access Control',  'name' => 'View Roles',                'slug' => 'roles.view'],
            ['group' => 'Access Control',  'name' => 'Create Role',               'slug' => 'roles.create'],
            ['group' => 'Access Control',  'name' => 'Edit Role',                 'slug' => 'roles.edit'],
            ['group' => 'Access Control',  'name' => 'Delete Role',               'slug' => 'roles.delete'],

            // --- Permission Management ---
            ['group' => 'Access Control',  'name' => 'View Permissions',          'slug' => 'permissions.view'],
            ['group' => 'Access Control',  'name' => 'Create Permission',         'slug' => 'permissions.create'],
            ['group' => 'Access Control',  'name' => 'Edit Permission',           'slug' => 'permissions.edit'],
            ['group' => 'Access Control',  'name' => 'Delete Permission',         'slug' => 'permissions.delete'],

            // --- Profile (own account) ---
            ['group' => 'Profile',         'name' => 'Edit Own Profile',          'slug' => 'profile.edit'],
            ['group' => 'Profile',         'name' => 'Change Own Password',       'slug' => 'profile.change-password'],
        ];

        foreach ($permissions as $data) {
            Permission::firstOrCreate(['slug' => $data['slug']], $data);
        }

        // ---------------------------------------------------------------
        // 2. Admin role — every permission
        // ---------------------------------------------------------------
        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name'        => 'Admin',
                'description' => 'Full access to all admin features',
            ]
        );
        $adminRole->permissions()->sync(Permission::pluck('id'));

        // ---------------------------------------------------------------
        // 3. Default admin user
        // ---------------------------------------------------------------
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('admin123'),
                'active'   => true,
            ]
        );
        $adminUser->roles()->syncWithoutDetaching([$adminRole->id]);

        $this->command->info('✔  Permissions seeded: ' . Permission::count());
        $this->command->info('✔  Admin role created with all permissions.');
        $this->command->info('✔  Admin user: admin@admin.com  |  Password: admin123');
    }
}
