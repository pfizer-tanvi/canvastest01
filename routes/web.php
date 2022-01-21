<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'login' => true,
    'logout' => true,
    'register' => false,
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::permanentRedirect('/home', '/');
Route::permanentRedirect('/password/reset', '/');
Route::permanentRedirect('/password/reset/{token}', '/');
Route::permanentRedirect('/redirect', '/login');

Route::middleware('auth')->group(function () {
    Route::get('/', DashboardController::class);
});
