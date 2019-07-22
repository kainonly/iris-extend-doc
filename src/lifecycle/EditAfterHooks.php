<?php

namespace laravel\curd\lifecycle;

interface EditAfterHooks
{
    /**
     * Modify post processing
     * @return mixed
     */
    public function __editAfterHooks();
}