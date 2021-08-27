# PHP-TASK

    PHP-TASK is a cron tool manage cron job without editing cron file

## PREPARE

- PHP 5.6+
- install php-redis

## INSTALL

```shell
composer install github.com/xiaoshouchen/php-task
```

## HOW TO USE

### get a redis client

```php
init_redis($host,$port,$password)
```

### implement a BaseScript

you need implement baseScript

```php
<?php

namespace xiaoshouchen\src;

class TestScript extends \BaseScript
{

    protected function action(): bool
    {
        echo 'test';
        return true;
    }
}
```

### execute a cron

```php
 
```