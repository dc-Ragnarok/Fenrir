<?php

use Exan\Fenrir\Bitwise\Bitwise;
use Exan\Fenrir\Const\Events;
use Exan\Fenrir\Discord;
use Exan\Fenrir\Websocket\Objects\Payload;

require './vendor/autoload.php';

$discord = new Discord('TOKEN',
    new Bitwise(), // Enable your desired Gateway intents
    options: ['raw_events' => true] // Enable the emitting of raw events
);

$discord->events->on(Events::RAW, function (Payload $payload) {
    echo 'Received event ', $payload->t, PHP_EOL;
});

$discord->connect(); // Nothing after this line is executed
