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
        $hasPermission = auth()->guard('admin')->user()->role->permissions();
        $currentRouteIsValid = $hasPermission->where('route_name', "*")->orWhere('route_name', $request->route()->getName())->first();

        if ($currentRouteIsValid) {
            return $next($request);
        }
        if ($hasPermission->get()->count() && !isset($currentRouteIsValid)) {
            return redirect()->route($hasPermission->first()->route_name);
        }
        if (!$hasPermission->get()->count()) {
            return redirect()->route('adminWelcome');
        }

        abort(403);
    }
}
