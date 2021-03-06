<?php

declare(strict_types=1);

namespace Shucream0117\PhalconLib\Services\QueueManager;

use Enqueue\Redis\RedisConnectionFactory;
use Interop\Queue\Context;
use Shucream0117\PhalconLib\Entities\RedisInfo;

/**
 * php-enqueue でRedisを使ったキュー処理をする時に使う氏
 * @see https://php-enqueue.github.io/transport/redis/
 */
class RedisQueueManager extends AbstractQueueManager
{
    private RedisInfo $redisInfo;

    public function __construct(RedisInfo $redisInfo)
    {
        $this->redisInfo = $redisInfo;
    }

    protected function getContext(): Context
    {
        return (new RedisConnectionFactory([
            'host' => $this->redisInfo->getHost(),
            'port' => $this->redisInfo->getPort(),
            'scheme_extensions' => ['phpredis'],
        ]))->createContext();
    }
}
