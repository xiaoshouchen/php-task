<?php

namespace XiaoshouChen\PhpTask;

class Cron
{
    private $name;

    /**
     * 设置脚本名称
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function minute()
    {
        $this->exec($this->name);
    }

    public function hour()
    {
        $time = date('i');
        if ($time == '00') {
            $this->exec($this->name);
        }
    }


    public function day()
    {
        $time = date('H:i');
        if ($time == '00:00') {
            $this->exec($this->name);
        }
    }

    public function month()
    {
        $time = date('d H:i');
        if ($time == '01 00:00') {
            $this->exec($this->name);
        }
    }

    /**
     * 在每小时的第$minute执行
     * @param int $minute
     */
    public function hourAt($minute)
    {
        $time = date('i');
        if ($time == str_pad((string)$minute, 2, '0', STR_PAD_LEFT)) {
            $this->exec($this->name);
        }
    }

    /**
     * 每天的几点执行
     * @param int $hour
     */
    public function dayAt($hour)
    {

        $time = date('H:i');
        if ($time == str_pad((string)$hour, 2, '0', STR_PAD_LEFT) . ':00') {
            $this->exec($this->name);
        }
    }

    /**
     * 每个月的第几天执行
     * @param int $day
     */
    public function monthAt($day)
    {
        $time = date('H:i');
        if ($time == str_pad((string)$day, 2, '0', STR_PAD_LEFT) . ':00') {
            $this->exec($this->name);
        }
    }

    /**
     * 在某个精准的时间执行一次
     * @param string $timestamp
     */
    public function once($timestamp)
    {
        $time = date('Y-m-d H:i');
        if ($time == $timestamp) {
            $this->exec($this->name);
        }
    }

    /**
     * @param string $format
     */
    public function diy($format)
    {
        $time = date('Y-m-d H:i');
        if ($time == $timestamp) {
            $this->exec($this->name);
        }
    }

    /**
     * 执行对应的脚本
     * @param string $name
     */
    private function exec($name)
    {
        (new $name)->run();
    }
}