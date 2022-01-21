<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Exception;
use Facades\App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ManageUsersCreate extends Controller
{
    public function __invoke(Request $request): string
    {
        $request->validate([
            'email' => "required|ends_with:@pfizer.com|unique:users",
        ]);
        try {
            return response()->json(['user' => User::createUser($request->all())], 200);
            // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([], 422);
            // @codeCoverageIgnoreEnd
        }
    }
}
