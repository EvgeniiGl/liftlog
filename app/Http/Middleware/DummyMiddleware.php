<?php

namespace App\Http\Middleware;

use Closure;

class DummyMiddleware
{
public function handle($request, Closure $next)
{
return $next($request);
}
}
