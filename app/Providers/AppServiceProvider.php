<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\Profile;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('components.header.notification-dropdown', function ($view) {
            $contacts = Contact::latest()->take(10)->get();
            $unreadCount = Contact::where('is_read', false)->count();
            $view->with('contacts', $contacts)->with('unreadCount', $unreadCount);
        });

        View::composer(['pages.leading.layouts.footer', 'pages.leading.layouts.header'], function ($view) {
            $profile = Profile::first();
            $view->with('profile', $profile);
        });
    }
}
