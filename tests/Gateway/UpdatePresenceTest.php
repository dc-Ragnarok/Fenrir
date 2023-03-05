<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Gateway;

use Exan\Fenrir\Enums\Gateway\StatusType;
use Exan\Fenrir\Websocket\Helpers\ActivityBuilder;
use Tests\Exan\Fenrir\Gateway\GatewayTestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class UpdatePresenceTest extends GatewayTestCase
{
    public function testUpdatePresence()
    {
        $this->gateway->updatePresence(
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
        $this->gateway->updatePresence(
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
