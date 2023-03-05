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
        $sendMessages = function (string $channelId, array $items) use (&$sendMessages, $discord) {
            if (count($items) === 0) {
                return;
            }

            $messageToSend = array_shift($items);

            $discord->rest->channel->createMessage(
                $channelId,
                (new MessageBuilder())->setContent($messageToSend)
            )->then(fn () => $sendMessages($channelId, $items));
        };

        $sendMessages($message->channel_id, ['this', 'will', 'send', 'in', 'order']);
    }
});

$discord->connect(); // Nothing after this line is executed
