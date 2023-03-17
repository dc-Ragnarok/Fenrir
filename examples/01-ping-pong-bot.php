<?php

use Exan\Fenrir\Bitwise\Bitwise;
use Exan\Fenrir\Constants\Events;
use Exan\Fenrir\Discord;
use Exan\Fenrir\Enums\Gateway\Intents;
use Exan\Fenrir\Rest\Helpers\Channel\MessageBuilder;
use Exan\Fenrir\Websocket\Events\MessageCreate;

require './vendor/autoload.php';

$discord = new Discord(
    'TOKEN'
);

$discord
    ->withGateway(Bitwise::from(
        Intents::GUILD_MESSAGES,
        Intents::DIRECT_MESSAGES,
        Intents::MESSAGE_CONTENT,
    ))
    ->withRest();

$discord->gateway->events->on(Events::MESSAGE_CREATE, function (MessageCreate $message) use ($discord) {
    if ($message->content === '!ping') {
        $discord->rest->channel->createMessage(
            $message->channel_id,
            (new MessageBuilder())
                ->setContent('pong!')
        );
    }
});

$discord->gateway->connect(); // Nothing after this line is executed
