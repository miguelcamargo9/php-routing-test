<?php

declare(strict_types=1);

namespace App;

use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonoLogger;

final class Logger
{
    public static function create(): MonoLogger
    {
        $log = new MonoLogger('app');
        $log->pushHandler(new StreamHandler(__DIR__ . '/../storage/app.log'));
        return $log;
    }
}
