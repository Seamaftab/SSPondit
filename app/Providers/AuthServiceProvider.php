<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Policies\OrderPolicy;
use App\Policies\UserPolicy;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('deletion_of_product', [ProductPolicy::class, 'delete']);

        Gate::define('access_to_change_power', [UserPolicy::class, 'viewAny']);

        Gate::define('looking_at_orders', [OrderPolicy::class, 'view']);

        Gate::define('edit_order', [OrderPolicy::class, 'update']);
    }
}
