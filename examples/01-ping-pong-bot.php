<?php

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Const\Events;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Enums\Gateway\Intents;
use Ragnarok\Fenrir\Rest\Helpers\Channel\MessageBuilder;
use Ragnarok\Fenrir\Websocket\Events\MessageCreate;

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
