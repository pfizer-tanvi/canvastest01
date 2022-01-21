<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSupportRequestValidation;
use Facades\App\Services\CreateSupportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupportRequestCreateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\CreateSupportRequestValidation  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(CreateSupportRequestValidation $request)
    {
        try {
            return response()->json(CreateSupportRequest::handle($request->all()), 200);
            // @codeCoverageIgnoreStart
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([], 422);
            // @codeCoverageIgnoreEnd
        }
    }
}
