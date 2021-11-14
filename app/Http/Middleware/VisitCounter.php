<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visit;
use Carbon\Carbon;

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
		$Check = Visit::where('ip',$request->ip())
						->whereNull('product_id')
						->get()
						->last();
		if($Check == null || Carbon::parse($Check->created_at)->addDay(1) < Carbon::now()){
			$Visit = new Visit();
			$Visit->ip = $request->ip();
			if(auth()->check())
				$Visit->user_id = auth()->user()->id;
			$Visit->save();
		}
		
		if(auth()->check() && $Check != null && $Check->user_id == null){
			$Check->user_id = auth()->user()->id;
			$Check->save();
		}

        return $next($request);
    }
}
