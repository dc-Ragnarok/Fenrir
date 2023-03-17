<?php

use Exan\Fenrir\Bitwise\Bitwise;
use Exan\Fenrir\Constants\Events;
use Exan\Fenrir\Discord;
use Exan\Fenrir\Websocket\Objects\Payload;

require './vendor/autoload.php';

$discord = new Discord('TOKEN');

$discord
    ->withGateway(new Bitwise(), raw: true)// Enable your desired Gateway intents
    ->withRest();

$discord->gateway->events->on(Events::RAW, function (Payload $payload) {
    echo 'Received event ', $payload->t, PHP_EOL;
});

$discord->gateway->connect(); // Nothing after this line is executed
