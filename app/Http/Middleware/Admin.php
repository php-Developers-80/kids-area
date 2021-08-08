<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{

    public function handle($request, Closure $next = null, $guard = null) {

        if (auth()->check()) {
            return $next($request);
        } else {
            return redirect('admin/login');
        }

    }
}
