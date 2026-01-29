<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string ...$roles
     * @return Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        \Log::info('CheckRole middleware triggered', [
            'user' => $request->user()?->email,
            'user_role' => $request->user()?->role,
            'required_roles' => $roles,
            'path' => $request->path(),
        ]);

        if (!$request->user()) {
            return redirect('login');
        }

        if (!in_array($request->user()->role, $roles)) {
            return redirect()->route('dashboard')->with('error', 'Je hebt geen rechten om die pagina te bezoeken.');
        }

        return $next($request);
    }
}
