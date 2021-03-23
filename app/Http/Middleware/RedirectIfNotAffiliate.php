<?php
namespace App\Http\Middleware;
use Closure;
class RedirectIfNotAffiliate
{
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
     
    public function handle($request, Closure $next, $guard="affiliate")
    {
        if(!auth()->guard($guard)->check()) {
            return redirect(route('affiliate.auth.login'));
        }
        return $next($request);
    }
}