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

use App\Http\Controllers\Apis\ManageUsersCreate;
use App\Http\Controllers\Apis\ManageUsersIndex;
use App\Http\Controllers\Apis\ManageUsersUpdate;
use App\Http\Controllers\Apis\SendMessageController;
use App\Http\Controllers\Apis\ShowGroupsAndUsersController;
use App\Http\Controllers\Apis\SupportRequestCreateController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExampleQueueController;
use App\Http\Controllers\GetMediaFileResponseController;
use App\Http\Controllers\ManageUsersIndexController;
use App\Http\Controllers\Media\MediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('logout', [LoginController::class, 'logout']);

Route::get('/home', function () {
    return redirect('/dashboard');
});

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware('can.admin')->group(function () {
    Route::get('admin/users', ManageUsersIndexController::class)->name('admin.users');
    Route::get('/api/manage-users', ManageUsersIndex::class)->name('manageUsers.index');
    Route::post('/api/manage-users', ManageUsersCreate::class)->name('manageUsers.create');
    Route::put('/api/manage-users/{user_id}', ManageUsersUpdate::class)->name('manageUsers.update');
    Route::get('/api/manage-users/groups', ShowGroupsAndUsersController::class)->name('manageUsers.groups');
});

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('testing', function (Request $request) {
        if (app()->environment() != 'local') {
            return redirect()->back();
        }
        return view('testing');
    });

    Route::get('/api/example', function (Request $request) {
        return response()->json(sprintf('Success calling API See Secret %s', env('SOME_SECRET')));
    });

    Route::post('/api/example', function (Request $request) {
        return response()->json([], 200);
    });

    Route::get('queue-worker-example', ExampleQueueController::class)->name('queue-worker-example');
    Route::post('/api/send-queue-message', SendMessageController::class)->name('send-message-example');

    Route::post('api/support-requests', SupportRequestCreateController::class)->name('support_requests.create');

    Route::get('/environment', static function () {
        $secret = env('SECRET', 'NOT_SET');
        $version = \Illuminate\Support\Facades\App::environment();
        Log::info(sprintf('TEST TESTING LOGGING %s', $version));
        return sprintf('<h1>Current Environment:</h1> %s v015 <h2>SECRET %s</h2>', $version, $secret);
    });
});

Route::get('/register', function () {
    return redirect('/login');
});

Route::post('/register', function () {
    return redirect('/login');
});

Route::post('/password/reset', function () {
    return redirect('/login');
});

Route::get('/password/reset/{token}', function () {
    return redirect('/login');
});

Route::middleware('can.admin')->group(function () {
    Route::view('media-example', 'examples.media.index')->name('examples.media');
    Route::get('media/{media}/file', GetMediaFileResponseController::class)
        ->middleware('signed')
        ->name('media.file');
    Route::apiResource('media', MediaController::class)->only(['index', 'store']);
});
