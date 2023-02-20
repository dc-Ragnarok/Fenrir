<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Discord;

use Exan\Fenrir\Enums\Gateway\StatusType;
use Exan\Fenrir\Websocket\Helpers\ActivityBuilder;
use Tests\Exan\Fenrir\Discord\DiscordTestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class UpdatePresenceTest extends DiscordTestCase
{
    public function testUpdatePresence()
    {
        $this->discord->updatePresence(
            StatusType::ONLINE,
            [new ActivityBuilder()],
        );

        $this->assertMessageSent([
            'status' => StatusType::ONLINE->value,
            'activities' => [[]],
            'afk' => false,
        ]);
    }

    public function testUpdatePresenceWithSince()
    {
        $this->discord->updatePresence(
            StatusType::ONLINE,
            [new ActivityBuilder()],
            since: 12345
        );

        $this->assertMessageSent([
            'status' => StatusType::ONLINE->value,
            'activities' => [[]],
            'afk' => false,
            'since' => 12345
        ]);
    }
}
