<?php

namespace XiaoshouChen\PhpTask;

use Redis;
use RedisException;

class RedisUtil
{

    private static $tryTimes = 0;
    private static $tryMaxTimes = 5;
    private static $instance;

    /**
     * @return Redis
     * @throws \Exception
     */
    public static function getInstance($host, $port, $password)
    {
        if (!self::$instance) {
            $redis = new Redis();
            $redis->pconnect($host, $port);
            if ($password) {
                $redis->auth($password);
            }
            self::$instance = $redis;
        }
        try {
            self::$instance->ping();
        } catch (RedisException $ex) {
            if (self::$tryTimes > self::$tryMaxTimes) {
                throw new \Exception("can't connect redis");
            } else {
                self::unsetInstance();
                self::$tryTimes++;
                echo "redis connect fail，retry after 5 seconds\n";
                sleep(5);
                self::getInstance($host, $port, $password);
            }
        }
        return self::$instance;
    }

    /**
     * 销毁redis实例
     */
    public static function unsetInstance()
    {
        self::$instance = null;
    }
}