<?php

use Exan\Dhp\Discord;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('name', [new StreamHandler('/path/to/your.log')]); // Log to a file
$log = new Logger('name', [new StreamHandler('php://stdout')]); // Log to stdout (terminal output)

$discord = new Discord('TOKEN', logger: $log);

$discord->connect(); // Nothing after this line is executed
