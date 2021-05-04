<?php
declare(strict_types=1);

namespace think\qcloud\extra;

use think\Service;

class ApiGatewayService extends Service
{
    public function register(): void
    {
        $this->app->bind(ApiGatewayInterface::class, function () {
            $config = $this->app->config->get('qcloud');
            return new ApiGatewayFactory($config);
        });
    }
}