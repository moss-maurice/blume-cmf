<?php

namespace Blume\Http\Controllers\Api\Auth;

use Blume\Http\Controllers\Controller;
use Blume\Http\Requests\Auth\LoginRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            return response()->json([
                'status' => 'success',
                'auth' => Auth::user() ? true : false,
                'message' => Auth::user() ? 'User is authenticated' : 'User is not authenticated',
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Requesting error',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    public function store(LoginRequest $request): JsonResponse
    {
        try {
            $request->authenticate();

            $request->session()
                ->regenerate();

            return response()->json([
                'status' => 'success',
                'message' => 'User authentication successfully',
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Requesting error',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request): JsonResponse
    {
        try {
            if (!Auth::check()) {
                throw new Exception('User is not authenticated', 401);
            }

            Auth::guard('web')
                ->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return response()->json([
                'status' => 'success',
                'message' => 'User logout successfully',
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Requesting error',
                'error' => $exception->getMessage(),
            ], $exception->getCode() ? $exception->getCode() : 500);
        }
    }
}
