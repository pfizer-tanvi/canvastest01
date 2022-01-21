<?php

namespace App\Http\Controllers\Apis;

use App\Models\User;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class ManageUsersUpdate extends Controller
{
    public function __invoke(Request $request, string $user_id): string
    {
        $request->validate([
            'email' => [
                "required", "ends_with:@pfizer.com",
                Rule::unique('users')->ignore($user_id)
            ]
        ]);
        try {
            $user = User::findOrFail($user_id);
            return response()->json(
                ['user' => $user->updateUser($user, $request->all())],
                200
            );
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([], 422);
        }
    }
}
