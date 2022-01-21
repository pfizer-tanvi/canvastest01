<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessNewJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExampleQueueController extends Controller
{
    /**
     * @param Request $request
     */
    public function __invoke(Request $request): string
    {
        try {
            return view("queue-example");
            // @codeCoverageIgnoreStart
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors("Sorry error with page");
            // @codeCoverageIgnoreEnd
        }
    }
}
