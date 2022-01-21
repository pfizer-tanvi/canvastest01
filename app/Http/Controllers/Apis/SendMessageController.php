<?php

namespace App\Http\Controllers\Apis;

use Composer\XdebugHandler\Process;

use App\Jobs\ProcessNewJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class SendMessageController extends Controller
{
    public function __invoke(Request $request): Response
    {
        try {
            ProcessNewJob::dispatch($request->toArray());
            return response()->json('sent', 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([], 422);
        }
    }
}
