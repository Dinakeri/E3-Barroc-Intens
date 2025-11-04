<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Route;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        $user = $request->user();
        $role = $user->role ?? 'none';

        $routeName = 'dashboards.' . $role;

        if (Route::has($routeName)) {
            return redirect()->intended(route($routeName));
        }

        // Fallback to Fortify's configured home path
        return redirect()->intended(config('fortify.home', '/'));
    }
}
