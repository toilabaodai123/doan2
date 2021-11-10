<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkOrderCode
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
		if(session('OrderCode') == null)
			return redirect('index');
		
		return $next($request);
    }
}
