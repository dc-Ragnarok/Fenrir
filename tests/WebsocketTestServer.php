<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$app = new \Ratchet\App('localhost', 8080);

$app->route('/echo', new \Ratchet\Server\EchoServer(), array('*'));

$app->run();
