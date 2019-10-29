<?php

namespace Lumen\Support\Middleware;

use Closure;

abstract class AuthVerify
{
    /**
     * @var string
     */
    protected $scene = 'default';

    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
