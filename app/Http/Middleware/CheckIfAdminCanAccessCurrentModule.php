<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfAdminCanAccessCurrentModule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $permissions = auth()->guard('admin')->user()->role->permissions()->get()->toArray();
        if(!count($permissions)){
            return redirect()->route('adminWelcome');
        }
        foreach ($permissions as $permission) {
            if ($permission['route_name'] === "*" || $request->routeIs($permission['route_name'])) {
                return $next($request);
            }
        }
        abort(403);
    }
}
