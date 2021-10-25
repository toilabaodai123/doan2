<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visit;

class VisitCounter
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
		$Check = Visit::where('ip',$request->ip())->where('view_type',1)->get()->last();
		if($Check == null || date_format($Check->created_at,'D M Y') != date_format(now(),'D M Y')){
			$Visit = new Visit();
			$Visit->ip = $request->ip();
			$Visit->view_type = 1;
			$Visit->save();
		}


        return $next($request);
    }
}
