<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Section;
use App\Models\Teacher;

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
public function boot()
{
    View::composer('admin.includes.sidebar', function ($view) {
        $view->with('sidebarSectionCount', Section::count());
    });

    View::composer('teacher.includes.sidebar', function ($view) {
        $user = auth()->user();

        if ($user) {
            $teacher = Teacher::with('sections.course')->where('user_id', $user->id)->first();
            $sections = $teacher ? $teacher->sections : collect([]);
        } else {
            $sections = collect([]);
        }

        $view->with('sections', $sections);
    });
}
}
