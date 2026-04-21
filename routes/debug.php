<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug-session', function () {
    $session = request()->session();
    $cookieName = $session->getName();
    $cookieValue = request()->cookie($cookieName);
    
    $data = [
        'cookie_name' => $cookieName,
        'cookie_value_raw' => $cookieValue,
        'session_id' => $session->getId(),
        'session_started' => $session->isStarted(),
        'session_data' => $session->all(),
        'session_file_exists' => file_exists(storage_path('framework/sessions/' . $session->getId())),
    ];
    
    // Write to a separate debug log
    file_put_contents(
        storage_path('logs/debug-session.log'),
        json_encode($data, JSON_PRETTY_PRINT) . "\n---\n",
        FILE_APPEND
    );
    
    return response()->json($data);
});
