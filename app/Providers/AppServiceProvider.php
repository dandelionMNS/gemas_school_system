<?php

namespace App\Providers;

use App\Models\Student;
use Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;

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
        // Auto-load all user when redirect to dashboard
        View::composer('dashboard', function ($view) {
            $view->with('users', User::all());
            $view->with('children', Student::all()->where("parent_id", Auth::user()->id));
        });
    }
}
