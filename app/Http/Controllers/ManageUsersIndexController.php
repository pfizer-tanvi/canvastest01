<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ManageUsersIndexController extends Controller
{
    /**
     * return View|RedirectResponse
     */
    public function __invoke(Request $request): string
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
