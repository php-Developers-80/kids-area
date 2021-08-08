<?php

namespace App\Http\Middleware\CustomMiddleWare;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Closure;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next,$permission, $guard)
    {
        if (!auth()->check()){
            return redirect()->route('admin.login');
        }

        if (checkAdminHavePermission($permission)) {
            return $next($request);
        } else{

            if ($request->ajax()) {
                return response()->json('no',500);
            }
            toastr()->error('لا تمتلك صلاحية الدخول');
            return redirect()->back();
        }//end else

    }//end function
}//end class
