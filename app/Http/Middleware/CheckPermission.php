<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubAdmin;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $sideMenuName, $permissionType)
    {
        // Allow if admin
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Allow if subadmin with permission
        if (Auth::guard('subadmin')->check()) {
            $subadminId = Auth::guard('subadmin')->id();

            if (SubAdmin::hasSpecificPermission($subadminId, $sideMenuName, $permissionType)) {
                return $next($request);
            }

            abort(403, 'Unauthorized action.');

        }

        // Not logged in
        return redirect()->route('login');
    }
}