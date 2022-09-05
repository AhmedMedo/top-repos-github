<?php

namespace App\Http\Middleware;

use App\Http\Resources\FailureResource;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->header('x-api-key') == config('app.api_token'))
        {
            return $next($request);
        }

        abort(new FailureResource([], 'Unauthorized' , Response::HTTP_UNAUTHORIZED));
    }
}
