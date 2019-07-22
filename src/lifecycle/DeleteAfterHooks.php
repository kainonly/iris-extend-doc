<?php

namespace laravel\curd\lifecycle;

interface DeleteAfterHooks
{
    /**
     * Delete post processing
     * @return mixed
     */
    public function __deleteAfterHooks();
}