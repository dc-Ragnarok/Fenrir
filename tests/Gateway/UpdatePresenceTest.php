<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway;

use Ragnarok\Fenrir\Enums\Gateway\StatusType;
use Ragnarok\Fenrir\Gateway\Helpers\ActivityBuilder;
use Tests\Ragnarok\Fenrir\Gateway\GatewayTestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class UpdatePresenceTest extends GatewayTestCase
{
    public function testUpdatePresence(): void
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

    public function testUpdatePresenceWithSince(): void
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
