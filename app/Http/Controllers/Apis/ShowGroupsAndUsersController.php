<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Repositories\GroupsAndUsersListRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ShowGroupsAndUsersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, GroupsAndUsersListRepository $repo)
    {
        try {
            return response()->json($repo->handle(), Response::HTTP_OK);
            // @codeCoverageIgnoreStart
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([], Response::HTTP_UNPROCESSABLE_ENTITY);
            // @codeCoverageIgnoreEnd
        }
    }
}
