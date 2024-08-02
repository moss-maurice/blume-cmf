<?php

namespace Blume\Http\Controllers\Api\Auth;

use Blume\Http\Controllers\Controller;
use Blume\Models\Users;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class RegisterationController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $user = DB::transaction(function () use ($request) {
                $validated = $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Users::class],
                    'password' => ['required', 'between:8,255', 'confirmed', Password::defaults()],
                    'password_confirmation' => ['required', 'between:8,255'],
                ]);

                $user = Users::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                ]);

                $role = Role::where('name', 'editor')
                    ->first();

                $user->assignRole($role);

                event(new Registered($user));

                Auth::login($user);

                return $user;
            });

            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully',
                'user' => $user->email,
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Registration failed',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }
}
