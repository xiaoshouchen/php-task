<?php

namespace XiaoshouChen\PhpTask;

abstract class BaseScript
{

    public function __construct()
    {
        $this->init();
    }

    protected $cache = true;

    abstract function init();

    private function generateKey()
    {
        $duration = date('Y_m_d_H_i');
        return get_called_class() . '_' . $duration;
    }

    /**
     * @throws \Exception
     */
    protected function beforeAction()
    {
        $redis = RedisUtil::getInstance("", "", "");
        $key = $this->generateKey();
        //生成缓存
        $cache = $redis->get($key);
        if ($cache && $this->cache) {
            return false;
        }
        $res = $redis->setnx($key, 1);
        if ($res) {
            $redis->expire($key, 60);
        } else {
            return false;
        }
        return true;
    }

    abstract protected function afterAction();

    abstract protected function action();

    /**
     * @throws \Exception
     */
    public function run()
    {
        $prepare = $this->beforeAction();
        if (!$prepare) {
            echo 'the script has executed,exit!';
            return true;
        }
        $execRes = $this->action();
        if ($execRes) {
            $this->afterAction();
        }
        return true;
    }

}