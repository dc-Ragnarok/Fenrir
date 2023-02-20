<?php

use Exan\Finrir\Bitwise\Bitwise;
use Exan\Finrir\Const\Events;
use Exan\Finrir\Discord;
use Exan\Finrir\Enums\Gateway\Intents;
use Exan\Finrir\Rest\Helpers\Channel\MessageBuilder;
use Exan\Finrir\Websocket\Events\MessageCreate;

require './vendor/autoload.php';

$discord = new Discord(
    'TOKEN',
    Bitwise::from(
        Intents::GUILD_MESSAGES,
        Intents::DIRECT_MESSAGES,
        Intents::MESSAGE_CONTENT,
    )
);

$discord->events->on(Events::MESSAGE_CREATE, function (MessageCreate $message) use ($discord) {
    if ($message->content === '!ping') {
        $discord->rest->channel->createMessage(
            $message->channel_id,
            (new MessageBuilder())
                ->setContent('pong!')
        );
    }
});

$discord->connect(); // Nothing after this line is executed
