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
     * Create Array Curd Route Controller
     * @param string $name Controller Name
     * @param $middleware Middleware
     * @param array $routeLists
     */
    public static function lists($name, $middleware, $routeLists = [])
    {
        Route::group([
            'prefix' => $name,
            'middleware' => $middleware
        ], function () use ($name, $routeLists) {
            foreach ($routeLists as $uri => $action) Route::post($uri, Str::studly($name) . '@' . $action);
        });
    }

    /**
     * Create Common Curd Route Controller
     * @param string $name Controller Name
     * @param array $middleware Middleware
     * @param bool $get
     * @param bool $originLists
     * @param bool $lists
     * @param bool $add
     * @param bool $edit
     * @param bool $delete
     */
    public static function support($name,
                                   $middleware = [],
                                   $get = false,
                                   $originLists = false,
                                   $lists = false,
                                   $add = false,
                                   $edit = false,
                                   $delete = false,
                                   $routeLists = [])
    {
        Route::group([
            'prefix' => $name,
            'middleware' => $middleware
        ], function () use ($name, $get, $originLists, $lists, $add, $edit, $delete, $routeLists) {
            if ($get) Route::post('get', Str::studly($name) . '@get');
            if ($originLists) Route::post('originLists', Str::studly($name) . '@originLists');
            if ($lists) Route::post('lists', Str::studly($name) . '@lists');
            if ($add) Route::post('add', Str::studly($name) . '@add');
            if ($edit) Route::post('edit', Str::studly($name) . '@edit');
            if ($delete) Route::post('delete', Str::studly($name) . '@delete');
            foreach ($routeLists as $uri => $action) Route::post($uri, Str::studly($name) . '@' . $action);
        });
    }
}