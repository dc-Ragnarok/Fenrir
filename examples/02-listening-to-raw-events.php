<?php

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\Constants\OpCodes;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Gateway\Handlers\GatewayEvent;
use Ragnarok\Fenrir\Gateway\Objects\Payload;

require './vendor/autoload.php';

class RawHandler extends GatewayEvent {
    public static function getEventName(): string
    {
        return OpCodes::EVENTS; // Or any other OP code
    }

    public function execute(): void
    {
        // ...
        // $this->payload
        // $this->connectionInterface
        // $this->logger
    }
}

$discord = new Discord('TOKEN');

$discord
    ->withGateway(new Bitwise())// Enable your desired Gateway intents
    ->withRest();

$discord->gateway->raw->register(RawHandler::class);

$discord->gateway->open(); // Nothing after this line is executed
