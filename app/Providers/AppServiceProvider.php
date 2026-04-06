<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Section;
use App\Models\Teacher;
   use App\Models\User;
   use App\Models\Student;
use Illuminate\Support\Facades\Auth;

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
          $teacher = Teacher::with('sections.gradeLevel')->where('user_id', $user->id)->first();
            $sections = $teacher ? $teacher->sections : collect([]);
        } else {
            $sections = collect([]);
        }

        $view->with('sections', $sections);
    });

    // Admin sidebar data
    View::composer('admin.includes.sidebar', function ($view) {
        $sidebarUserCount = User::count();       // Total users
        $sidebarSectionCount = Section::count(); // Total sections

        $view->with([
            'sidebarUserCount' => $sidebarUserCount,
            'sidebarSectionCount' => $sidebarSectionCount,
        ]);
    });


        View::composer('student.*', function ($view) {
        $student = Student::with('user')
            ->where('user_id', Auth::id())
            ->first();

        $view->with('student', $student);
    });
}
}
