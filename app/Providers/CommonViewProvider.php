<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composer\ShowComposer;


class CommonViewProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // $categories = Category::pluck('name','slug')->toArray();

        // $view->with('categories', $categories);
        View::composer('components.frontend.partials.navbar', ShowComposer::class);
    }
}
