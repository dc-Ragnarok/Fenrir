<?php

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Gateway\Objects\Payload;

require './vendor/autoload.php';

$discord = new Discord('TOKEN');

$discord
    ->withGateway(new Bitwise())// Enable your desired Gateway intents
    ->withRest();

$discord->gateway->events->on(Events::RAW, static function (Payload $payload) {
    echo 'Received event ', $payload->t, PHP_EOL;
});

$discord->gateway->open(); // Nothing after this line is executed
