<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ManageUsersIndexController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            return view('admin.users.index');
            // @codeCoverageIgnoreStart
        } catch (\Exception $e) {
            Log::error($e);
            return back()->withErrors(['Error with your request']);
            // @codeCoverageIgnoreEnd
        }
    }
}
