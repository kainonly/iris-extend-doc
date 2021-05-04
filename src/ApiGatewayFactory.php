<?php
declare(strict_types=1);

namespace think\qcloud\extra;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ApiGatewayFactory implements ApiGatewayInterface
{
    /**
     * 腾讯云API网关配置
     * @var array
     */
    private array $option;
    /**
     * Http客户端
     * @var Client
     */
    private Client $client;

    /**
     * ApiGatewayFactory constructor.
     * @param array $option
     */
    public function __construct(array $option)
    {
        $this->option = $option['api'];
        $this->client = new Client([
            'base_uri' => $this->option['url'],
            'timeout' => $this->option['timeout'] ?? 2.0,
        ]);
    }

    /**
     * 生产签名
     * @param array $header
     * @param string $md5
     * @param string $path
     * @return string
     */
    private function factorySignature(array $header, string $md5, string $path): string
    {
        ksort($header);
        $str = '';
        foreach ($header as $key => $value) {
            $key = strtolower($key);
            if ($key === 'accept') {
                continue;
            }
            $str .= $key . ': ' . $value . "\n";
        }
        $str .= "POST\n";
        $str .= "application/json\n";
        $str .= "application/json\n";
        $str .= $md5 . "\n";
        $str .= $path;
        return base64_encode(hash_hmac('sha1', $str, $this->option['appsecret'], true));
    }

    /**
     * 发起应用认证请求
     * @param string $name 函数名
     * @param string $path 路径
     * @param array $body 请求体
     * @return ResponseInterface
     * @noinspection PhpDocMissingThrowsInspection
     */
    public function request(string $name, string $path, array $body): ResponseInterface
    {
        $headers = [
            'X-Date' => Carbon::now()->toRfc7231String(),
            'Source' => 'apigw ' . $name,
            'Accept' => 'application/json'
        ];
        $md5 = base64_encode(md5(json_encode($body)));
        $signature = $this->factorySignature($headers, $md5, $path);
        $authorization = 'hmac ';
        $authorization .= 'id="' . $this->option['appkey'] . '", ';
        $authorization .= 'algorithm="hmac-sha1", ';
        $authorization .= 'headers="source x-date", ';
        $authorization .= 'signature="' . $signature . '"';
        $headers['Content-MD5'] = $md5;
        $headers['Authorization'] = $authorization;
        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->client->post('/release' . $path, [
            'headers' => $headers,
            'json' => $body,
            'http_errors' => false
        ]);
    }
}