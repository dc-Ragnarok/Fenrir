<?php

declare(strict_types=1);

use Ratchet\App;
use Ratchet\Server\EchoServer;

require __DIR__ . '/../vendor/autoload.php';

$app = new App('localhost', 8080);

$app->route('/echo', new EchoServer(), array('*'));

$app->run();
