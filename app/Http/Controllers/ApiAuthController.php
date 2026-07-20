<?php

namespace Modules\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Http\Responses\ApiResponse;

class ApiAuthController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            (new Middleware('throttle:5,1'))->only('login'),
        ];
    }

    /**
     * @group Authentication
     *
     * Revoke the current API token.
     *
     * @authenticated
     *
     * @response 200 { "success": true, "data": { "message": "Logged out successfully." } }
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::ok(['message' => 'Logged out successfully.']);
    }

    /**
     * @group Authentication
     *
     * Obtain an API token.
     *
     * @bodyParam email string required The user's email or username.
     * @bodyParam password string required The user's password.
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "token": "1|abc123...",
     *     "user": { "id": "...", "name": "John", "email": "john@example.com" }
     *   }
     * }
     * @response 401 { "success": false, "message": "Invalid credentials." }
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials)) {
            return ApiResponse::error('Invalid credentials.', 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return ApiResponse::ok([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
