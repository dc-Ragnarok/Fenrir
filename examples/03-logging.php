<?php

use Exan\Fenrir\Bitwise\Bitwise;
use Exan\Fenrir\Discord;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('name', [new StreamHandler('/path/to/your.log')]); // Log to a file
$log = new Logger('name', [new StreamHandler('php://stdout')]); // Log to stdout (terminal output)

$discord = new Discord(
    'TOKEN',
    $log
);

$discord
    ->withGateway()
    ->withRest();

$discord->gateway->connect(); // Nothing after this line is executed
