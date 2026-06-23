<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminPermission
{
    /**
     * Maps every admin route name → required permission slug.
     * Routes NOT listed here are accessible to any authenticated user.
     */
    private array $map = [

        // Dashboard
        'admin.dashboard'                    => 'dashboard.view',

        // Products
        'admin.products.index'               => 'products.view',
        'admin.products.create'              => 'products.create',
        'admin.products.store'               => 'products.create',
        'admin.products.edit'                => 'products.edit',
        'admin.products.update'              => 'products.edit',
        'admin.products.destroy'             => 'products.delete',

        // Categories
        'admin.categories.index'             => 'categories.view',
        'admin.categories.create'            => 'categories.create',
        'admin.categories.store'             => 'categories.create',
        'admin.categories.edit'              => 'categories.edit',
        'admin.categories.update'            => 'categories.edit',
        'admin.categories.destroy'           => 'categories.delete',

        // Sliders
        'admin.sliders.index'                => 'sliders.view',
        'admin.sliders.create'               => 'sliders.create',
        'admin.sliders.store'                => 'sliders.create',
        'admin.sliders.edit'                 => 'sliders.edit',
        'admin.sliders.update'               => 'sliders.edit',
        'admin.sliders.destroy'              => 'sliders.delete',

        // Orders
        'admin.orders.index'                 => 'orders.view',
        'admin.orders.show'                  => 'orders.view-detail',
        'admin.orders.update'                => 'orders.update-status',
        'admin.orders.destroy'               => 'orders.delete',

        // Contacts
        'admin.contacts.index'               => 'contacts.view',
        'admin.contacts.destroy'             => 'contacts.delete',

        // Feedback / Testimonials
        'admin.feedbacks.index'              => 'feedback.view',
        'admin.feedbacks.create'             => 'feedback.create',
        'admin.feedbacks.store'              => 'feedback.create',
        'admin.feedbacks.edit'               => 'feedback.edit',
        'admin.feedbacks.update'             => 'feedback.edit',
        'admin.feedbacks.destroy'            => 'feedback.delete',

        // Pages
        'admin.pages.edit'                   => 'pages.edit',
        'admin.pages.update'                 => 'pages.edit',

        // Company Profile
        'admin.company-profiles.index'       => 'company-profile.view',
        'admin.company-profiles.create'      => 'company-profile.create',
        'admin.company-profiles.store'       => 'company-profile.create',
        'admin.company-profiles.edit'        => 'company-profile.edit',
        'admin.company-profiles.update'      => 'company-profile.edit',

        // Users
        'admin.users.index'                  => 'users.view',
        'admin.users.create'                 => 'users.create',
        'admin.users.store'                  => 'users.create',
        'admin.users.edit'                   => 'users.edit',
        'admin.users.update'                 => 'users.edit',
        'admin.users.destroy'                => 'users.delete',

        // Roles
        'admin.roles.index'                  => 'roles.view',
        'admin.roles.create'                 => 'roles.create',
        'admin.roles.store'                  => 'roles.create',
        'admin.roles.edit'                   => 'roles.edit',
        'admin.roles.update'                 => 'roles.edit',
        'admin.roles.destroy'                => 'roles.delete',

        // Permissions
        'admin.permissions.index'            => 'permissions.view',
        'admin.permissions.create'           => 'permissions.create',
        'admin.permissions.store'            => 'permissions.create',
        'admin.permissions.edit'             => 'permissions.edit',
        'admin.permissions.update'           => 'permissions.edit',
        'admin.permissions.destroy'          => 'permissions.delete',
    ];

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Super-admin role bypasses all permission checks
        if ($user->hasRole('admin')) {
            return $next($request);
        }

        $route      = $request->route();
        $routeName  = $route ? $route->getName() : null;
        $permission = $this->map[$routeName] ?? null;

        if ($permission && ! $user->hasPermission($permission)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden.'], 403);
            }
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
