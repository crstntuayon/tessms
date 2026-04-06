<?php

use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;

// Public student lookup API (for enrollment)
Route::get('/students/lookup', [StudentController::class, 'lookupByLrn']);
