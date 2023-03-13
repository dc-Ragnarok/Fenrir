<?php

use Exan\Fenrir\Bitwise\Bitwise;
use Exan\Fenrir\Const\Events;
use Exan\Fenrir\Discord;
use Exan\Fenrir\Enums\Gateway\Intents;
use Exan\Fenrir\Rest\Helpers\Channel\MessageBuilder;
use Exan\Fenrir\Websocket\Events\MessageCreate;

require './vendor/autoload.php';

$discord = new Discord('TOKEN');

$discord
    ->withGateway(Bitwise::from(
        Intents::GUILD_MESSAGES,
        Intents::DIRECT_MESSAGES,
        Intents::MESSAGE_CONTENT,
    ))
    ->withRest();

$discord->gateway->events->on(Events::MESSAGE_CREATE, function (MessageCreate $message) use ($discord) {
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

        $sendMessages($message->channel_id, ['this', 'will', 'sent', 'in', 'order']);
    }
});

$discord->gateway->connect(); // Nothing after this line is executed
