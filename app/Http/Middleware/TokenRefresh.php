<?php

namespace App\Http\Middleware;

use Closure;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class TokenRefresh
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Passport::personalAccessTokensExpireIn(Carbon::now()->addHours(10));
		return $next($request);
    }
}
