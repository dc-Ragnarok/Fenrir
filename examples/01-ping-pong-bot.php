<?php

use Exan\Dhp\Const\Events;
use Exan\Dhp\Discord;
use Exan\Dhp\Rest\Helpers\Channel\MessageBuilder;
use Exan\Dhp\Websocket\Events\MessageCreate;

require './vendor/autoload.php';

$discord = new Discord('TOKEN');

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
