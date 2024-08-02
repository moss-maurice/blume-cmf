<?php

namespace Blume\Foundation\Core;

use Blume\Foundation\Core\Abstracts\ApiNode;
use Blume\Models\Roles;
use Blume\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthResolver extends ApiNode
{
    public function isLogged(): bool
    {
        return Auth::check();
    }

    public function isRegistered(string $email): bool
    {
        return Users::where('email', $email)->count() ? true : false;
    }

    public function register(string $name, string $email, string $password, string $role = null, bool $autoLogin = false): bool
    {
        blume()->events()->callEvent('auth.onRegister.before');

        if (is_null($role) || empty($role)) {
            $role = config('permission.default_role');
        }

        if (!$this->isLogged()) {
            $user = Users::where('email', $email)
                ->first();

            if (!$user) {
                $user = Users::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                ]);

                if ($user) {
                    $role = Roles::where('name', $role)
                        ->first();

                    if ($role) {
                        $user->assignRole($role);
                    }

                    if ($autoLogin) {
                        $this->loginByUser($user);
                    }

                    blume()->events()->callEvent('auth.onRegister');
                    blume()->events()->callEvent('auth.onRegister.success');
                    blume()->events()->callEvent('auth.onRegister.after');

                    return true;
                }
            }
        }

        blume()->events()->callEvent('auth.onRegister.error');
        blume()->events()->callEvent('auth.onRegister.after');

        return false;
    }

    public function login(string $email, string $password, bool $rememberMe = false): bool
    {
        blume()->events()->callEvent('auth.onLogin.before');

        if (!$this->isLogged()) {
            Auth::attempt([
                'email' => $email,
                'password' => $password,
            ], $rememberMe);

            if ($this->isLogged()) {
                blume()->events()->callEvent('auth.onLogin');
                blume()->events()->callEvent('auth.onLogin.success');
                blume()->events()->callEvent('auth.onLogin.after');

                return true;
            }
        }

        blume()->events()->callEvent('auth.onRegister.error');
        blume()->events()->callEvent('auth.onRegister.after');

        return false;
    }

    public function loginByUser(Users $user, bool $rememberMe = false): bool
    {
        blume()->events()->callEvent('auth.onLogin.before');

        if (!$this->isLogged()) {
            Auth::login($user, $rememberMe);

            if ($this->isLogged()) {
                blume()->events()->callEvent('auth.onLogin');
                blume()->events()->callEvent('auth.onLogin.success');
                blume()->events()->callEvent('auth.onLogin.after');

                return true;
            }
        }

        blume()->events()->callEvent('auth.onLogin.error');
        blume()->events()->callEvent('auth.onLogin.after');

        return false;
    }

    public function loginById(int $id, bool $rememberMe = false): bool
    {
        blume()->events()->callEvent('auth.onLogin.before');

        if (!$this->isLogged()) {
            Auth::loginUsingId($id, $rememberMe);

            if ($this->isLogged()) {
                blume()->events()->callEvent('auth.onLogin');
                blume()->events()->callEvent('auth.onLogin.success');
                blume()->events()->callEvent('auth.onLogin.after');

                return true;
            }
        }

        blume()->events()->callEvent('auth.onLogin.error');
        blume()->events()->callEvent('auth.onLogin.after');

        return false;
    }

    public function logout(): bool
    {
        blume()->events()->callEvent('auth.onLogout.before');

        if ($this->isLogged()) {
            Auth::logout();

            if (!$this->isLogged()) {
                blume()->events()->callEvent('auth.onLogout');
                blume()->events()->callEvent('auth.onLogout.success');
                blume()->events()->callEvent('auth.onLogout.after');

                return true;
            }
        }

        blume()->events()->callEvent('auth.onLogout.error');
        blume()->events()->callEvent('auth.onLogout.after');

        return false;
    }

    public function sendResetPasswordLink(string $email): bool
    {
        blume()->events()->callEvent('auth.onPasswordResetSendLink.before');

        $status = Password::sendResetLink([
            'email' => $email,
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            blume()->events()->callEvent('auth.onPasswordResetSendLink');
            blume()->events()->callEvent('auth.onPasswordResetSendLink.success');
            blume()->events()->callEvent('auth.onPasswordResetSendLink.after');

            return true;
        }

        blume()->events()->callEvent('auth.onPasswordResetSendLink.error');
        blume()->events()->callEvent('auth.onPasswordResetSendLink.after');

        return false;
    }

    public function resetPassword(string $email, string $password, string $token): bool
    {
        blume()->events()->callEvent('auth.onPasswordReset.before');

        $status = Password::reset([
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
            'token' => $token,
        ], function (Users $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])
                ->setRememberToken(Str::random(60));

            $user->save();
        });

        if ($status === Password::PASSWORD_RESET) {
            blume()->events()->callEvent('auth.onPasswordReset');
            blume()->events()->callEvent('auth.onPasswordReset.success');
            blume()->events()->callEvent('auth.onPasswordReset.after');

            return true;
        }

        blume()->events()->callEvent('auth.onPasswordReset.error');
        blume()->events()->callEvent('auth.onPasswordReset.after');

        return false;
    }
}
