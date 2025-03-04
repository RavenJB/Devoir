<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require __DIR__ . '/../vendor/autoload.php';

$log = new Logger('verbes');
$log->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::DEBUG));

return $log;