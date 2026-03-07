<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // This shares $cartCount with the navigation view every time it is loaded
        View::composer('layouts.navigation', function ($view) {
            $cart = session()->get('cart', []);
            
            // If your session 'cart' stores multiple quantities per item, 
            // you might need array_sum instead of count. 
            // count() simply counts the number of unique items in the array.
            $cartCount = is_array($cart) ? count($cart) : 0;

            $view->with('cartCount', $cartCount);
        });
    }
}