<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AdminSetting;

class checkMaintenance
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
		$Setting = AdminSetting::get()->last();
		if($Setting->is_maintenance == 0)
			return $next($request);
		else
			return redirect()->to('bao-tri');
    }
}
