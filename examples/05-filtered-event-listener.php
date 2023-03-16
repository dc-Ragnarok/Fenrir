<?php

use Exan\Fenrir\Bitwise\Bitwise;
use Exan\Fenrir\Constants\Events;
use Exan\Fenrir\Discord;
use Exan\Fenrir\Enums\Gateway\Intents;
use Exan\Fenrir\FilteredEventEmitter;
use Exan\Fenrir\Rest\Helpers\Channel\MessageBuilder;
use Exan\Fenrir\Websocket\Events\MessageCreate;
use Exan\Fenrir\Websocket\Events\MessageReactionAdd;

require './vendor/autoload.php';

$discord = new Discord(
    'TOKEN',
    Bitwise::from(
        Intents::GUILD_MESSAGES,
        Intents::DIRECT_MESSAGES,
        Intents::MESSAGE_CONTENT,
        Intents::GUILD_MESSAGE_REACTIONS,
        Intents::DIRECT_MESSAGE_REACTIONS,
    )
);

$discord->gateway->events->on(Events::MESSAGE_CREATE, function (MessageCreate $message) use ($discord) {
    if ($message->content === '!createListener') {
        $filteredListener = new FilteredEventEmitter(
            $discord->gateway->events, // Fenrir's `EventHandler`. This can be any `EventEmitterInterface`
            Events::MESSAGE_REACTION_ADD, // The event to listen to
            fn (MessageReactionAdd $messageReactionAdd) => $messageReactionAdd->message_id === $message->id, // The filter for the event
            20, // Stops the listener automatically after 20 seconds
            1 // Only allow 1 event to go through
        );

        $filteredListener->on(Events::MESSAGE_REACTION_ADD, function (MessageReactionAdd $messageReactionAdd) use ($discord) {
            $discord->rest->channel->createMessage(
                $messageReactionAdd->channel_id,
                (new MessageBuilder())
                    ->setContent(sprintf(
                        'Reaction %s was added',
                        $messageReactionAdd->emoji->name ?? $messageReactionAdd->emoji->id
                    ))
            );
        });

        $filteredListener->start(); // Activate the filtered listener, time starts ticking from now on
    }
});

$discord->gateway->connect();
