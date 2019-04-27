<?php

namespace laravel\bit\facade;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Class CurdRoute
 * @package laravel\bit\facade
 */
final class CurdRoute
{
    /**
     * Quickly generate CURD routes
     * @param string $path ControllerName
     * @param array $routeLists Array routing uri
     * @param array $middleware Middleware
     */
    public static function support($path, $routeLists, $middleware = [])
    {
        Route::group([
            'prefix' => $path,
            'middleware' => $middleware
        ], function () use ($path, $routeLists) {
            foreach ($routeLists as $uri) {
                Route::post($uri, Str::studly($path) . '@' . $uri);
            }
        });
    }
}