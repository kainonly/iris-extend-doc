<?php
declare(strict_types=1);

namespace think\qcloud\extra;

use Psr\Http\Message\ResponseInterface;

interface ApiGatewayInterface
{
    public function request(string $name, string $path, array $body): ResponseInterface;
}