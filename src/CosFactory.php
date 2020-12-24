<?php
declare (strict_types=1);

namespace think\qcloud\extra;

use Exception;
use Overtrue\CosClient\ObjectClient;
use think\facade\Request;

/**
 * 对象存储处理类
 * Class CosFactory
 * @package think\qcloud\extra\common
 */
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
}