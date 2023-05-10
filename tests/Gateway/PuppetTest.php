<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Closure;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\CompositeExpectation;
use Mockery\MockInterface;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Enums\Gateway\ActivityType;
use Ragnarok\Fenrir\Enums\Gateway\StatusType;
use Ragnarok\Fenrir\Gateway\Helpers\ActivityBuilder;
use Ragnarok\Fenrir\Gateway\Puppet;

class PuppetTest extends MockeryTestCase
{
    private Puppet $puppet;
    private Websocket&MockInterface $websocket;

    protected function setUp(): void
    {
        $this->websocket = Mockery::mock(Websocket::class);
        $this->puppet = new Puppet($this->websocket);
    }

    private function expectMessage(Closure $fn, bool $useBucket = false): CompositeExpectation
    {
        return $this->websocket->expects()
            ->send()
            ->with(Mockery::on(static function ($payload) use ($fn) {
                $message = json_decode($payload, true);

                return $fn($message);
            }), $useBucket);
    }

    public function testConnect(): void
    {
        $this->websocket->expects()
            ->open()
            ->with('::url::')
            ->once();

        $this->puppet->connect('::url::');
    }

    public function testTerminate(): void
    {
        $this->websocket->expects()
            ->close()
            ->with(1234, '::reason::')
            ->once();

        $this->puppet->terminate(1234, '::reason::');
    }

    public function testSendHeatbeat(): void
    {
        $this->expectMessage(function ($payload) {
            $this->assertEquals(1, $payload['op']);
            $this->assertEquals(123, $payload['d']);

            return true;
        })->once();

        $this->puppet->sendHeartBeat(123);
    }

    public function testIdentify(): void
    {
        $this->expectMessage(function ($payload) {
            $this->assertEquals(2, $payload['op']);
            $this->assertEquals('::token::', $payload['d']['token']);
            $this->assertEquals(123, $payload['d']['intents']);

            return true;
        }, true)->once();

        $this->puppet->identify('::token::', new Bitwise(123));
    }

    public function testUpdatePresence(): void
    {
        $activityBuilder = ActivityBuilder::new()
            ->setType(ActivityType::GAME)
            ->setName('::name::');
        $this->expectMessage(function ($payload) use ($activityBuilder) {
            $this->assertEquals(3, $payload['op']);
            $this->assertEquals(StatusType::AFK->value, $payload['d']['status']);
            $this->assertFalse($payload['d']['afk']);
            $this->assertEquals([$activityBuilder->get()], $payload['d']['activities']);
            $this->assertFalse(isset($payload['d']['since']));

            return true;
        }, true)->once();

        $this->puppet->updatePresence(StatusType::AFK, [$activityBuilder], false);
    }

    public function testUpdatePresenceWithSince(): void
    {
        $activityBuilder = ActivityBuilder::new()
            ->setType(ActivityType::GAME)
            ->setName('::name::');
        $this->expectMessage(function ($payload) use ($activityBuilder) {
            $this->assertEquals(3, $payload['op']);
            $this->assertEquals(StatusType::AFK->value, $payload['d']['status']);
            $this->assertFalse($payload['d']['afk']);
            $this->assertEquals([$activityBuilder->get()], $payload['d']['activities']);
            $this->assertEquals(456, $payload['d']['since']);

            return true;
        }, true)->once();

        $this->puppet->updatePresence(StatusType::AFK, [$activityBuilder], false, 456);
    }

    public function testResume(): void
    {
        $this->expectMessage(function ($payload) {
            $this->assertEquals(6, $payload['op']);
            $this->assertEquals('::token::', $payload['d']['token']);
            $this->assertEquals('::session id::', $payload['d']['session_id']);
            $this->assertEquals(123, $payload['d']['seq']);

            return true;
        }, true)->once();

        $this->puppet->resume('::token::', '::session id::', 123);
    }

    public function testRequestGuildMembersByQuery(): void
    {
        $this->expectMessage(function ($payload) {
            $this->assertEquals(8, $payload['op']);
            $this->assertEquals('::guild id::', $payload['d']['guild_id']);
            $this->assertEquals('::query::', $payload['d']['query']);
            $this->assertTrue($payload['d']['presences']);
            $this->assertEquals(1234, $payload['d']['limit']);
            $this->assertFalse(isset($payload['d']['nonce']));

            return true;
        }, true)->once();

        $this->puppet->requestGuildMembersByQuery('::guild id::', '::query::', 1234, true);
    }

    public function testRequestGuildMembersByQueryWithNonce(): void
    {
        $this->expectMessage(function ($payload) {
            $this->assertEquals(8, $payload['op']);
            $this->assertEquals('::guild id::', $payload['d']['guild_id']);
            $this->assertEquals('::query::', $payload['d']['query']);
            $this->assertTrue($payload['d']['presences']);
            $this->assertEquals(1234, $payload['d']['limit']);
            $this->assertEquals('::nonce::', $payload['d']['nonce']);

            return true;
        }, true)->once();

        $this->puppet->requestGuildMembersByQuery('::guild id::', '::query::', 1234, true, '::nonce::');
    }

    public function testRequestGuildMembersByUserIds(): void
    {
        $this->expectMessage(function ($payload) {
            $this->assertEquals(8, $payload['op']);
            $this->assertEquals('::guild id::', $payload['d']['guild_id']);
            $this->assertEquals(['::user id::'], $payload['d']['user_ids']);
            $this->assertTrue($payload['d']['presences']);
            $this->assertEquals(1234, $payload['d']['limit']);
            $this->assertFalse(isset($payload['d']['nonce']));

            return true;
        }, true)->once();

        $this->puppet->requestGuildMembersByUserIds('::guild id::', ['::user id::'], 1234, true);
    }

    public function testRequestGuildMembersByUserIdsWithNonce(): void
    {
        $this->expectMessage(function ($payload) {
            $this->assertEquals(8, $payload['op']);
            $this->assertEquals('::guild id::', $payload['d']['guild_id']);
            $this->assertEquals(['::user id::'], $payload['d']['user_ids']);
            $this->assertTrue($payload['d']['presences']);
            $this->assertEquals(1234, $payload['d']['limit']);
            $this->assertEquals('::nonce::', $payload['d']['nonce']);

            return true;
        }, true)->once();

        $this->puppet->requestGuildMembersByUserIds('::guild id::', ['::user id::'], 1234, true, '::nonce::');
    }
}
