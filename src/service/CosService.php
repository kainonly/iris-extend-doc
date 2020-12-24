<?php
declare (strict_types=1);

namespace think\qcloud\extra\service;

use think\qcloud\extra\common\CosFactory;
use think\Service;

class CosService extends Service
{
    public function register(): void
    {
        $this->app->bind('cos', function () {
            $config = $this->app->config
                ->get('qcloud');
            return new CosFactory($config);
        });
    }
}