<?php

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\FilteredEventEmitter;
use Ragnarok\Fenrir\Gateway\Events\MessageCreate;
use Ragnarok\Fenrir\Gateway\Events\MessageReactionAdd;
use Ragnarok\Fenrir\Rest\Helpers\Channel\MessageBuilder;

require './vendor/autoload.php';

$discord = (new Discord(
    'TOKEN',
))->withGateway(Bitwise::from(
    Intent::GUILD_MESSAGES,
    Intent::DIRECT_MESSAGES,
    Intent::MESSAGE_CONTENT,
    Intent::GUILD_MESSAGE_REACTIONS,
    Intent::DIRECT_MESSAGE_REACTIONS,
))->withRest();

$discord->gateway->events->on(Events::MESSAGE_CREATE, static function (MessageCreate $message) use ($discord) {
    if ($message->content === '!createListener') {
        $filteredListener = new FilteredEventEmitter(
            $discord->gateway->events, // Fenrir's `EventHandler`. This can be any `EventEmitterInterface`
            Events::MESSAGE_REACTION_ADD, // The event to listen to
            static fn (MessageReactionAdd $messageReactionAdd) => $messageReactionAdd->message_id === $message->id, // The filter for the event
            20, // Stops the listener automatically after 20 seconds
            1 // Only allow 1 event to go through
        );

        $filteredListener->on(Events::MESSAGE_REACTION_ADD, static function (MessageReactionAdd $messageReactionAdd) use ($discord) {
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

$discord->gateway->open();
