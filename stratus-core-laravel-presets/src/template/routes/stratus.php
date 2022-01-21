<?php

Route::middleware('web')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::redirect('/home', '/dashboard');

    Route::redirect('/', '/dashboard');

    Route::middleware('auth')->get('/api/example', function (Request $request) {
        return response()->json(['message' => 'Success calling API']);
    });
});

Route::middleware(['web'])
    ->namespace('StratusCoreLaravelPresets\Http\Controllers')
    ->group(function () {
        Auth::routes([
            'register' => false,
            'reset' => false,
            'confirm' => false,
            'verify' => false,
        ]);
    });
