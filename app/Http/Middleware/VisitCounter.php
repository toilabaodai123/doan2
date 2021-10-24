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
		$Check = Visit::where('ip',$request->ip())->where('view_type',1)->first();
		//dd($Check);
		if($Check == null || $Check->created_at->format('d') != date('d')){
			$Visit = new Visit();
			$Visit->ip = $request->ip();
			$Visit->view_type = 1;
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			$Visit->save();
		}


        return $next($request);
    }
}
