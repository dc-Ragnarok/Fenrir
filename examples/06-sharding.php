<?php

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Gateway\Shard;

require './vendor/autoload.php';

$discord = new Discord(
    'TOKEN'
);

$discord
    ->withGateway(Bitwise::from(
        // ...
    ))
    ->withRest();

$discord->gateway->shard(new Shard(1, 16));

$discord->gateway->open(); // Nothing after this line is executed
