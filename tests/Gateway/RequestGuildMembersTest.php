<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Gateway;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class RequestGuildMembersTest extends GatewayTestCase
{
    public function testRequestGuildMembersByQuery()
    {
        $this->gateway->requestGuildMembersByQuery(
            '::guild id::',
            '',
            123,
            true
        );

        $this->assertMessageSent(
            [
                'guild_id' => '::guild id::',
                'query' => '',
                'limit' => 123,
                'presences' => true
            ]
        );
    }

    public function testRequestGuildMembersByQueryWithNonce()
    {
        $this->gateway->requestGuildMembersByQuery(
            '::guild id::',
            '',
            123,
            true,
            '::nonce::'
        );

        $this->assertMessageSent(
            [
                'guild_id' => '::guild id::',
                'query' => '',
                'limit' => 123,
                'presences' => true,
                'nonce' => '::nonce::'
            ]
        );
    }

    public function testRequestGuildMembersByUserIds()
    {
        $this->gateway->requestGuildMembersByUserIds(
            '::guild id::',
            ['::user id::'],
            123,
            true
        );

        $this->assertMessageSent(
            [
                'guild_id' => '::guild id::',
                'user_ids' => ['::user id::'],
                'limit' => 123,
                'presences' => true
            ]
        );
    }

    public function testRequestGuildMembersByUserIdsWithNonce()
    {
        $this->gateway->requestGuildMembersByUserIds(
            '::guild id::',
            ['::user id::'],
            123,
            true,
            '::testRequestGuildMembersByUserIdsWithNonce::'
        );

        $this->assertMessageSent(
            [
                'guild_id' => '::guild id::',
                'user_ids' => ['::user id::'],
                'limit' => 123,
                'presences' => true,
                'nonce' => '::testRequestGuildMembersByUserIdsWithNonce::'
            ]
        );
    }
}
