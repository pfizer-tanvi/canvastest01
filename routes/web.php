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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Auth::routes();

Route::get('logout', 'Auth\LoginController@logout');

Route::get('/home', function () {
    return redirect("/dashboard");
});

Route::get('/', function () {
    return redirect("/dashboard");
});

Route::middleware('can.admin')->group(function () {
    Route::get("admin/users", "ManageUsersIndexController")->name("admin.users");
    Route::get("/api/manage-users", "Apis\ManageUsersIndex")->name("manageUsers.index");
    Route::post("/api/manage-users", "Apis\ManageUsersCreate")->name("manageUsers.create");
    Route::put("/api/manage-users/{user_id}", "Apis\ManageUsersUpdate")->name("manageUsers.update");
    Route::get("/api/manage-users/groups", "Apis\ShowGroupsAndUsersController")->name("manageUsers.groups");
});

Route::middleware('auth')->group(function () {
    Route::get("dashboard", "DashboardController")->name("dashboard");

    Route::get("testing", function (Request $request) {
        if (app()->environment() != "local") {
            return redirect()->back();
        }
        return view("testing");
    });

    Route::get('/api/example', function (Request $request) {
        return response()->json(sprintf('Success calling API See Secret %s', env("SOME_SECRET")));
    });



    Route::post('/api/example', function (Request $request) {
        return response()->json([], 200);
    });


    Route::get("queue-worker-example", "ExampleQueueController")->name("queue-worker-example");
    Route::post("/api/send-queue-message", "Apis\SendMessageController")->name("send-message-example");

    Route::post(
        "api/support-requests",
        "Apis\SupportRequestCreateController"
    )->name("support_requests.create");


    Route::get('/environment', static function () {
        $secret = env("SECRET", "NOT_SET");
        $version = \Illuminate\Support\Facades\App::environment();
        Log::info(sprintf("TEST TESTING LOGGING %s", $version));
        return sprintf('<h1>Current Environment:</h1> %s v014 <h2>SECRET %s</h2>', $version, $secret);
    });
});

Route::get('/register', function () {
    return redirect("/login");
});

Route::post('/register', function () {
    return redirect("/login");
});

Route::post('/password/reset', function () {
    return redirect("/login");
});

Route::get('/password/reset/{token}', function () {
    return redirect("/login");
});
