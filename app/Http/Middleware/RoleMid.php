<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;

class RoleMid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null, $type = null)
    {
        if ($type != null) {
            if ($type != auth($guard)->user()->role) {
                if ($request->wantsJson()) {
                    return response('Forbidden', 403);
                } 
            }
        }

        $role = Role::where('role_name', auth($guard)->user()->role)->first();
        if ($role->role_access == 1) {
            return $next($request);
        } else {
            auth()->logout();
            return redirect('login')->with('error-notif', 'User tidak memiliki hak akses');
        }

        return $next($request);
    }
}
