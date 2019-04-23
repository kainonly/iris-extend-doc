<?php

namespace lumen\bit\facade;


use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Class Curd
 * @package laravel\bit\facade
 */
class Curd extends Facade
{
    /**
     * Create Bit Curd Route Controller
     * @param string $name Controller name
     * @param array $traits traits name
     * @param array $middleware
     */
    public static function support($name, $traits = [], $middleware = [])
    {
        Route::group([
            'prefix' => $name,
            'middleware' => $middleware
        ], function () use ($name, $traits) {
            if (in_array('get', $traits)) Route::post('get', Str::studly($name) . '@get');
            if (in_array('originLists', $traits)) Route::post('originLists', Str::studly($name) . '@originLists');
            if (in_array('lists', $traits)) Route::post('lists', Str::studly($name) . '@lists');
            if (in_array('add', $traits)) Route::post('add', Str::studly($name) . '@add');
            if (in_array('edit', $traits)) Route::post('edit', Str::studly($name) . '@edit');
            if (in_array('delete', $traits)) Route::post('delete', Str::studly($name) . '@delete');
        });
    }
}