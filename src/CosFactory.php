<?php
declare (strict_types=1);

namespace think\qcloud\extra;

use Carbon\Carbon;
use Exception;
use Overtrue\CosClient\ObjectClient;
use think\facade\Request;

class CosFactory
{
    /**
     * 腾讯云配置
     * @var array
     */
    private array $option;

    /**
     * OssFactory constructor.
     * @param array $option
     */
    public function __construct(array $option)
    {
        $this->option = $option;
    }

    /**
     * 获取对象存储配置
     */
    public function getOption(): array
    {
        return $this->option;
    }

    /**
     * 上传至对象存储
     * @param string $name 文件名称
     * @return string
     * @throws Exception
     */
    public function put(string $name): string
    {
        $file = Request::file($name);
        $fileName = date('Ymd') . '/' .
            uuid()->toString() . '.' .
            $file->getOriginalExtension();
        $object = new ObjectClient([
            'app_id' => $this->option['app_id'],
            'secret_id' => $this->option['secret_id'],
            'secret_key' => $this->option['secret_key'],
            'bucket' => $this->option['cos']['bucket'],
            'region' => $this->option['cos']['region'],
        ]);
        $object->putObject(
            $fileName,
            file_get_contents($file->getRealPath())
        );
        return $fileName;
    }

    /**
     * 删除对象
     * @param array $keys 对象名
     * @throws Exception
     */
    public function delete(array $keys): void
    {
        $object = new ObjectClient([
            'app_id' => $this->option['app_id'],
            'secret_id' => $this->option['secret_id'],
            'secret_key' => $this->option['secret_key'],
            'bucket' => $this->option['cos']['bucket'],
            'region' => $this->option['cos']['region'],
        ]);
        $object->deleteObjects([
            'Delete' => [
                'Quiet' => true,
                'Object' => [...array_map(static fn($v) => ['Key' => $v], $keys)]
            ]
        ]);
    }

    /**
     * 生成客户端上传 COS 对象存储签名
     * @param array $conditions 表单域的合法值
     * @param int $expired 过期时间
     * @return array
     * @throws Exception
     */
    public function generatePostPresigned(array $conditions, int $expired = 600): array
    {
        $date = Carbon::now()->setTimezone('UTC');
        $keyTime = $date->unix() . ';' . ($date->unix() + $expired);
        $filename = date('Ymd') . '/' . uuid()->toString();
        $policy = json_encode([
            'expiration' => $date->addSeconds($expired)->toISOString(),
            'conditions' => [
                ['bucket' => $this->option['cos']['bucket'] . '-' . $this->option['app_id']],
                ['starts-with', '$key', $filename],
                ['q-sign-algorithm' => 'sha1'],
                ['q-ak' => $this->option['secret_id']],
                ['q-sign-time' => $keyTime],
                ...$conditions
            ]
        ]);
        $signKey = hash_hmac('sha1', $keyTime, $this->option['secret_key']);
        $stringToSign = sha1($policy);
        $signature = hash_hmac('sha1', $stringToSign, $signKey);
        return [
            'filename' => $filename,
            'type' => 'cos',
            'option' => [
                'ak' => $this->option['secret_id'],
                'policy' => base64_encode($policy),
                'key_time' => $keyTime,
                'sign_algorithm' => 'sha1',
                'signature' => $signature
            ],
        ];
    }
}