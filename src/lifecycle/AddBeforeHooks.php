<?php

namespace laravel\curd\lifecycle;

interface AddBeforeHooks
{
    /**
     * Add pre-processing
     * @return boolean
     */
    public function __addBeforeHooks();
}