<?php
declare (strict_types=1);

namespace think\qcloud\extra;

use Carbon\Carbon;
use Exception;
use Overtrue\CosClient\ObjectClient;
use think\facade\Request;

class CosFactory implements CosInterface
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
     * @return array
     * @inheritDoc
     */
    public function getOption(): array
    {
        return $this->option;
    }

    /**
     * @param string $name
     * @return string
     * @throws Exception
     * @inheritDoc
     */
    public function put(string $name): string
    {
        $file = Request::file($name);
        $fileName = date('Ymd') . '/' . uuid()->toString() . '.' . $file->getOriginalExtension();
        $object = new ObjectClient([
            'app_id' => $this->option['app_id'],
            'secret_id' => $this->option['secret_id'],
            'secret_key' => $this->option['secret_key'],
            'bucket' => $this->option['cos']['bucket'],
            'region' => $this->option['cos']['region'],
        ]);
        $object->putObject($fileName, file_get_contents($file->getRealPath()));
        return $fileName;
    }

    /**
     * @param array $keys
     * @throws Exception
     * @inheritDoc
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
     * @param array $conditions
     * @param int $expired
     * @return array
     * @throws Exception
     * @inheritDoc
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