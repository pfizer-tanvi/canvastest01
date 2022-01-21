<?php

namespace App\Http\Controllers\Apis;

use App\ManageUsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class ManageUsersIndex extends Controller
{
    public function __invoke(Request $request, ManageUsersRepository $repo): Response
    {
        try {
            return response()->json($repo->users($request->all()));
            // @codeCoverageIgnoreStart
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([], 422);
            // @codeCoverageIgnoreEnd
        }
    }
}
