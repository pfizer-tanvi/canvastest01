<?php

namespace App\Http\Controllers\Apis;

use Facades\App\User;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class ManageUsersCreate extends Controller
{
    public function __invoke(Request $request): string
    {
        $request->validate([
            'email' => "required|ends_with:@pfizer.com|unique:users"
        ]);
        try {
            return response()->json(['user' => User::createUser($request->all())], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([], 422);
        }
    }
}
