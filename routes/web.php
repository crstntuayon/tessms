<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/pending-approval', function () {
    return view('auth.pending');
})->name('auth.pending');

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
             Route::get('/teacher/exports/sf1', [App\Http\Controllers\Teacher\ExportController::class, 'sf1'])
    ->name('teacher.exports.sf1');

    
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
  // Core Values Routes
    Route::get('/sections/{section}/core-values', [App\Http\Controllers\Teacher\CoreValueController::class, 'index'])
        ->name('sections.core-values.index');
    
    Route::post('/sections/{section}/core-values', [App\Http\Controllers\Teacher\CoreValueController::class, 'store'])
        ->name('sections.core-values.store');

        Route::get('/sections/{section}/students', [App\Http\Controllers\Teacher\StudentController::class, 'index'])
               ->name('sections.students');
        Route::get('/sections/{section}/students/create', [App\Http\Controllers\Teacher\StudentController::class, 'create'])
               ->name('students.create');
        Route::post('/sections/{section}/students', [App\Http\Controllers\Teacher\StudentController::class, 'store'])
               ->name('students.store');

          // 👉 ADD THESE (YOU ARE MISSING THIS PART)
        Route::get('/students/{student}', [App\Http\Controllers\Teacher\StudentController::class, 'show'])->name('students.show');
        Route::get('/students/{student}/edit', [App\Http\Controllers\Teacher\StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [App\Http\Controllers\Teacher\StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{student}', [App\Http\Controllers\Teacher\StudentController::class, 'destroy'])->name('students.destroy');

       Route::get('/communications', [App\Http\Controllers\Teacher\CommunicationController::class, 'index'])
            ->name('communications.index');
        Route::post('/communications/{section}', [App\Http\Controllers\Teacher\CommunicationController::class, 'store'])
        ->name('teacher.communications.store');

        

    Route::get('/sections/{section}/attendance',
        [App\Http\Controllers\Teacher\AttendanceController::class, 'index'])
        ->name('sections.attendance');
        

    Route::post('/sections/{section}/attendance',
        [App\Http\Controllers\Teacher\AttendanceController::class, 'store'])
        ->name('sections.attendance.store');

            Route::get('/sections/{section}/grades',
        [App\Http\Controllers\Teacher\GradeController::class, 'index'])
        ->name('sections.grades');

    Route::post('/sections/{section}/grades',
        [App\Http\Controllers\Teacher\GradeController::class, 'store'])
        ->name('sections.grades.store');


        //SCHOOL FORMS ROUTES
    Route::get('/sf1', [App\Http\Controllers\Teacher\SchoolFormController::class, 'sf1'])->name('sf1');
    Route::get('/sf2', [App\Http\Controllers\Teacher\SchoolFormController::class, 'sf2'])->name('sf2');
    Route::get('/sf5', [App\Http\Controllers\Teacher\SchoolFormController::class, 'sf5'])->name('sf5');
    Route::get('/sf3', [App\Http\Controllers\Teacher\SchoolFormController::class, 'sf3'])->name('sf3');
    Route::get('/sf9', [App\Http\Controllers\Teacher\SchoolFormController::class, 'sf9'])->name('sf9');
    Route::get('/sf10', [App\Http\Controllers\Teacher\SchoolFormController::class, 'sf10'])->name('sf10');
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


   
   
// OFFICIAL STUDENT ROUTE
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
 Route::get('/subjects', [App\Http\Controllers\Student\SubjectController::class, 'index'])->name('subjects');


 Route::get('/attendance', [App\Http\Controllers\Student\AttendanceController::class, 'index'])->name('attendance');
   // ✅ ADD THIS
    Route::get('/attendance/export', [App\Http\Controllers\Student\AttendanceController::class, 'export'])
        ->name('attendance.export');


 Route::get('/grades', [App\Http\Controllers\Student\GradesController::class, 'index'])->name('grades');
 Route::get('/classmates', [App\Http\Controllers\Student\ClassmatesController::class, 'index'])->name('classmates');
 Route::get('/assignments', [App\Http\Controllers\Student\AssignmentsController::class, 'index'])->name('assignments');
 Route::get('/achievements', [App\Http\Controllers\Student\AchievementController::class, 'index'])->name('achievements'); 
 Route::get('/messages', [App\Http\Controllers\Student\MessageController::class, 'index'])->name('messages');
 Route::get('/announcements', [App\Http\Controllers\Student\AnnouncementController::class, 'index'])->name('announcements');


 Route::get('/profile', [App\Http\Controllers\Student\ProfileController::class, 'index'])->name('profile');
 Route::post('/profile/photo', [App\Http\Controllers\Student\ProfileController::class, 'updatePhoto'])->name('profile.photo');
 Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

 

 Route::get('/help', [App\Http\Controllers\Student\HelpController::class, 'index'])->name('help');
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


    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export/{format}', [\App\Http\Controllers\Admin\ReportController::class, 'export'])
        ->name('reports.export')
        ->where('format', 'pdf|excel|csv|xlsx');

         Route::post('school-year/set-active', [\App\Http\Controllers\Admin\SchoolYearController::class, 'setActive'])
        ->name('school-year.set-active');
         Route::resource('school-years', \App\Http\Controllers\Admin\SchoolYearController::class);
        Route::post('/school-year/end', [\App\Http\Controllers\Admin\SchoolYearController::class, 'endSchoolYear'])
    ->name('school-year.end');
// Fixed: Changed to match naming convention
Route::post('/school-year/start', [\App\Http\Controllers\Admin\SchoolYearController::class, 'startSchoolYear'])
    ->name('school-year.start');

Route::post('/school-year/regenerate-qr', [\App\Http\Controllers\Admin\SchoolYearController::class, 'regenerateQrCode'])
    ->name('school-year.regenerate-qr');

Route::get('/school-year/qr-code/{qrCode}/download', [\App\Http\Controllers\Admin\SchoolYearController::class, 'downloadQrCode'])
    ->name('school-year.download-qr');
// Public enrollment routes (no auth required)
Route::get('/enrollment/form/{token}', [\App\Http\Controllers\Admin\EnrollmentController::class, 'showForm'])->name('enrollment.form');
Route::post('/enrollment/submit', [\App\Http\Controllers\Admin\EnrollmentController::class, 'submit'])->name('enrollment.submit');
Route::get('/enrollment/success', [\App\Http\Controllers\Admin\EnrollmentController::class, 'success'])->name('enrollment.success');
Route::get('/enrollment/subjects', [\App\Http\Controllers\Admin\EnrollmentController::class, 'getSubjects'])->name('enrollment.subjects');
Route::get('/enrollment/sections', [\App\Http\Controllers\Admin\EnrollmentController::class, 'getSections'])->name('enrollment.sections');




          Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])
        ->name('settings.index');
         Route::put('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])
        ->name('settings.update');
         Route::post('/settings/backup', [\App\Http\Controllers\Admin\SettingsController::class, 'backup'])->name('settings.backup');
         Route::post('/settings/clear-cache', [\App\Http\Controllers\Admin\SettingsController::class, 'clearCache'])->name('settings.clear-cache');
         Route::post('/settings/reset', [\App\Http\Controllers\Admin\SettingsController::class, 'reset'])->name('settings.reset');
         Route::get('/settings/export/{type}', [\App\Http\Controllers\Admin\SettingsController::class, 'export'])->name('settings.export');
         Route::post('/settings/regenerate-api-key', [\App\Http\Controllers\Admin\SettingsController::class, 'regenerateApiKey'])->name('settings.regenerate-api-key');
    
   
          Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
          Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
          Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');


         Route::resource('events', App\Http\Controllers\Admin\EventController::class);
         Route::resource('students', \App\Http\Controllers\Admin\StudentController::class);
          Route::resource('teachers', App\Http\Controllers\Admin\TeacherController::class);

    Route::get('/pending-registrations', [App\Http\Controllers\Admin\PendingRegistrationController::class, 'index'])
        ->name('pending-registrations.index');
    
    Route::get('/pending-registrations/{student}/details', [App\Http\Controllers\Admin\PendingRegistrationController::class, 'details'])
        ->name('pending-registrations.details');
    
    Route::post('/pending-registrations/{student}/approve', [App\Http\Controllers\Admin\PendingRegistrationController::class, 'approve'])
        ->name('pending-registrations.approve');
    
    Route::post('/pending-registrations/{student}/reject', [App\Http\Controllers\Admin\PendingRegistrationController::class, 'reject'])
        ->name('pending-registrations.reject');
        

    Route::resource('users', App\Http\Controllers\Admin\UserController::class);

    
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
