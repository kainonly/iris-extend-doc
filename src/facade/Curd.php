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
                                   $delete = false)
    {
        Route::group([
            'prefix' => $name,
            'middleware' => $middleware
        ], function () use ($name, $get, $originLists, $lists, $add, $edit, $delete) {
            if ($get) Route::post('get', Str::studly($name) . '@get');
            if ($originLists) Route::post('originLists', Str::studly($name) . '@originLists');
            if ($lists) Route::post('lists', Str::studly($name) . '@lists');
            if ($add) Route::post('add', Str::studly($name) . '@add');
            if ($edit) Route::post('edit', Str::studly($name) . '@edit');
            if ($delete) Route::post('delete', Str::studly($name) . '@delete');
        });
    }
}