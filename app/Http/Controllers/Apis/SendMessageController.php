<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessNewJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SendMessageController extends Controller
{
    public function __invoke(Request $request): Response
    {
        try {
            ProcessNewJob::dispatch($request->toArray());

            return response()->json('sent', 200);
            // @codeCoverageIgnoreStart
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([], 422);
        }
        // @codeCoverageIgnoreEnd
    }
}
