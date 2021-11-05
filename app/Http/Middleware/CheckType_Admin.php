<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckType_Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		if(auth()->user()->user_type != 'Người dùng')
			return $next($request);
		else
			return redirect('/index');
        return $next($request);
    }
}
