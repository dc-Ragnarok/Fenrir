<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#integration-delete
 */
class IntegrationDelete
{
    public string $id;
    public string $guild_id;
    public ?string $application_id;
}
