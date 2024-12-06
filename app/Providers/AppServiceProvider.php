<?php

namespace App\Providers;

use App\Models\FeeType;
use App\Models\Student;
use Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Parentt;
use App\Models\Classes;

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
            $user = Auth::user();

            switch ($user->type) {
                case 'admin':
                    $view->with('users', User::all());
                case 'teacher':
                    $teacherID = Teacher::where('user_id', Auth::id())->value('id');
                    $view->with('students', Student::whereHas('class', function ($query) use ($teacherID) {
                        $query->where('teacher_id', $teacherID);
                    })->get());
                    $view->with('class_teaches', Classes::where('teacher_id', $teacherID)->get());
                    $view->with('feetypes', FeeType::all());
                    

                case 'parent':
                    $parentID = Parentt::where('user_id', Auth::id())->value('id');
                    $view->with('children', Student::where('parent_id', $parentID)->get());
                    $view->with('feetypes', FeeType::all());
            }

        });
    }
}
