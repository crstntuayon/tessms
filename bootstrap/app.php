<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\InjectAppearance::class);
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle 419 Page Expired errors - redirect to login with fresh session
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            if ($request->is('login') || $request->is('student/login') || $request->is('logout')) {
                return redirect('/')
                    ->withInput($request->except('_token'))
                    ->withErrors(['login' => 'Your session expired. Please try again.']);
            }

            if ($request->is('register') || $request->is('enroll') || $request->is('enroll/check')) {
                return redirect()->back()
                    ->withInput($request->except('_token'))
                    ->withErrors(['error' => 'Your session expired. Please refresh the page and try again.']);
            }
            
            return redirect()->back()
                ->withInput($request->except('_token'))
                ->withErrors(['error' => 'Your session expired. Please try again.']);
        });
    })->create();
