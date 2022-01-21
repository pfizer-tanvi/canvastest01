<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * @param Request $request
     */
    public function __invoke(Request $request): object
    {
        try {
            return view("dashboard");
            // @codeCoverageIgnoreStart
        } catch (\Exception $e) {
            Log::error($e);
            return back()->withErrors(["System Error sorry"]);
            // @codeCoverageIgnoreEnd
        }
    }
}
