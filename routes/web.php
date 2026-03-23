<?php

use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
     Route::get('/teacher/profile/edit', [App\Http\Controllers\Teacher\ProfileController::class, 'edit'])->name('teacher.profile.edit');// donot remove
     Route::put('/teacher/profile', [App\Http\Controllers\Teacher\ProfileController::class, 'update'])->name('teacher.profile.update'); //donot remove
     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/teacher/dashboard', [App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('teacher.dashboard');
    Route::get('/registrar/dashboard', [App\Http\Controllers\Registrar\DashboardController::class, 'index'])->name('registrar.dashboard');
    Route::get('/student/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student.dashboard');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('sections', App\Http\Controllers\Admin\SectionController::class);
});

Route::resource('students', App\Http\Controllers\Admin\StudentController::class);

// OFFICIAL TEACHER ROUTE
Route::middleware(['auth'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Teacher\DashboardController::class, 'index'])
        ->name('dashboard');

           Route::resource('sections', App\Http\Controllers\Teacher\SectionsController::class);
             Route::resource('grades', App\Http\Controllers\Teacher\GradeController::class);
               Route::get('reports', [App\Http\Controllers\Teacher\ReportsController::class, 'index'])
            ->name('reports.index');
             Route::get('exports/sf1', [App\Http\Controllers\Teacher\ExportController::class, 'sf1'])->name('exports.sf1');
              Route::resource('attendance', App\Http\Controllers\Teacher\AttendanceController::class);
              Route::post('/attendance/bulk-store', [App\Http\Controllers\Teacher\AttendanceController::class, 'bulkStore'])
        ->name('attendance.bulk-store');
              Route::get('/exports/sf9', [App\Http\Controllers\Teacher\ExportController::class, 'sf9'])
        ->name('exports.sf9');
         Route::post('/interventions', [App\Http\Controllers\Teacher\InterventionController::class, 'store'])
        ->name('interventions.store');
         Route::get('attendance/monthly', [App\Http\Controllers\Teacher\AttendanceController::class, 'monthly'])->name('attendance.monthly');
           Route::get('reports/class-record', [App\Http\Controllers\Teacher\ReportsController::class, 'classRecord'])
        ->name('reports.class-record');

          Route::get('/profile', [App\Http\Controllers\Teacher\ProfileController::class, 'index'])->name('profile');
         
            

    // Update settings
   // Route::put('/settings', [App\Http\Controllers\Teacher\ProfileController::class, 'updateSettings'])->name('settings.update');
    
   // Route::get('/settings', [App\Http\Controllers\Teacher\ProfileController::class, 'settings'])->name('settings');
    

   // SETTINGS ROUTE
     Route::get('/settings', [App\Http\Controllers\Teacher\SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [App\Http\Controllers\Teacher\SettingsController::class, 'update'])->name('settings.update');
    Route::delete('/settings/sessions/{session}', [App\Http\Controllers\Teacher\SettingsController::class, 'revokeSession'])->name('settings.revoke-session');
    Route::delete('/settings/sessions', [App\Http\Controllers\Teacher\SettingsController::class, 'revokeAllSessions'])->name('settings.revoke-all-sessions');
    Route::get('/settings/export', [App\Http\Controllers\Teacher\SettingsController::class, 'exportData'])->name('settings.export-data');
    Route::delete('/settings/account', [App\Http\Controllers\Teacher\SettingsController::class, 'deleteAccount'])->name('settings.delete-account');


      Route::get('sections/{section}/students', [App\Http\Controllers\Teacher\SectionsController::class, 'students'])->name('sections.students');
    Route::get('sections/{section}/attendance', [App\Http\Controllers\Teacher\SectionsController::class, 'attendance'])->name('sections.attendance');
    Route::get('sections/{section}/grades', [App\Http\Controllers\Teacher\SectionsController::class, 'grades'])->name('sections.grades');
});

Route::middleware(['auth', 'role:Teacher'])->prefix('teacher')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Teacher\DashboardController::class, 'index'])
        ->name('teacher.dashboard');

       
});


Route::middleware(['auth', 'role:Student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])
            ->name('dashboard');
    });


   
   

Route::middleware(['auth', 'role:Student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/report-card', 
            [App\Http\Controllers\Student\ReportCardController::class, 'index']
        )->name('report.card');
    });


Route::prefix('registrar')->name('registrar.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Registrar\DashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('teacher')->name('teacher.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('student')->name('student.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
});



// OFFICIAL ADMIN ROUTE
// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\SectionController;

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Students Management
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

    // Teachers Management
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('teachers.destroy');

    // Sections Management
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/sections/create', [SectionController::class, 'create'])->name('sections.create');
    Route::post('/sections', [SectionController::class, 'store'])->name('sections.store');
    Route::get('/sections/{section}/edit', [SectionController::class, 'edit'])->name('sections.edit');
    Route::put('/sections/{section}', [SectionController::class, 'update'])->name('sections.update');
    Route::delete('/sections/{section}', [SectionController::class, 'destroy'])->name('sections.destroy');


      Route::resource('attendance', \App\Http\Controllers\Admin\AttendanceController::class);
        Route::resource('grades', \App\Http\Controllers\Admin\GradeController::class);
         Route::resource('reports', \App\Http\Controllers\Admin\ReportController::class);
         Route::post('school-year/set-active', [\App\Http\Controllers\Admin\SchoolYearController::class, 'setActive'])
        ->name('school-year.set-active');

          Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])
        ->name('settings.index');
         Route::put('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])
        ->name('settings.update');
         Route::post('/settings/backup', [\App\Http\Controllers\Admin\SettingsController::class, 'backup'])->name('settings.backup');
         Route::post('/settings/clear-cache', [\App\Http\Controllers\Admin\SettingsController::class, 'clearCache'])->name('settings.clear-cache');
         Route::post('/settings/reset', [\App\Http\Controllers\Admin\SettingsController::class, 'reset'])->name('settings.reset');
         Route::get('/settings/export/{type}', [\App\Http\Controllers\Admin\SettingsController::class, 'export'])->name('settings.export');
         Route::post('/settings/regenerate-api-key', [\App\Http\Controllers\Admin\SettingsController::class, 'regenerateApiKey'])->name('settings.regenerate-api-key');
    
          Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
          Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
          Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
          Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');


         Route::resource('events', App\Http\Controllers\Admin\EventController::class);
         Route::resource('students', \App\Http\Controllers\Admin\StudentController::class);
          Route::resource('teachers', App\Http\Controllers\Admin\TeacherController::class);
          
});


Route::get('/admin/dashboard/stats', function () {
    return response()->json([
        'students' => \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'student'))->count(),
        'teachers' => \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'teacher'))->count(),
        'sections' => \App\Models\Section::count(),
    ]);
})->middleware(['auth']);

Route::get('/admin/dashboard/stats', [App\Http\Controllers\Admin\DashboardController::class, 'getStats'])->name('admin.dashboard.stats');

Route::put('/admin/sections/{section}/assign-teacher',
    [SectionController::class, 'assignTeacher'])->name('sections.assignTeacher');

Route::get('/admin/sections/{section}/students',
    [SectionController::class, 'students'])->name('sections.students');

use App\Http\Controllers\ExportController;

Route::get('/admin/export/teacher/{id}', [ExportController::class, 'teacher'])
    ->name('export.teacher');


Route::prefix('admin')->name('sections.')->middleware(['auth'])->group(function () {
    Route::post('/assign-teacher-bulk/{teacher}', [App\Http\Controllers\Admin\SectionController::class, 'assignTeacherBulk'])
         ->name('assignTeacherBulk');
});









require __DIR__.'/auth.php';
