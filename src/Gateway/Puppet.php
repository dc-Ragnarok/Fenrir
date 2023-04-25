<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway;

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Enums\Gateway\StatusType;
use Ragnarok\Fenrir\Gateway\Helpers\ActivityBuilder;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\Retrier;
use Ragnarok\Fenrir\Websocket;

class Puppet
{
    private const MAX_RECONNECT_ATTEMPTS = 3;

    public function __construct(
        private Websocket $websocket,
        private LoggerInterface $logger = new NullLogger(),
    ) {
    }

    public function connect(string $url)
    {
        return Retrier::retryAsync(self::MAX_RECONNECT_ATTEMPTS, function (int $attempt) use ($url) {
            $this->logger->info(
                sprintf('Attempt #%d connecting to %s', $attempt, $url)
            );

            return $this->websocket->open($url);
        });
    }

    public function terminate(int $code, string $reason = '')
    {
        $this->websocket->close($code, $reason);
    }

    public function sendHeartBeat(?int $sequence)
    {
        $this->sendPayload([
            'op' => 1,
            'd' => $sequence
        ], false);
    }

    public function identify(string $token, Bitwise $intents): void
    {
        $this->sendPayload([
            'op' => 2,
            'd' => [
                'token' => $token,
                'intents' => $intents->get(),
                'properties' => [
                    'os' => PHP_OS,
                    'browser' => 'Ragnarok\Fenrir',
                    'device' => 'Ragnarok\Fenrir',
                ]
            ]
        ]);
    }

    /**
     * @see https://discord.com/developers/docs/topics/gateway-events#update-presence
     */
    public function updatePresence(
        StatusType $status,
        array $activities,
        bool $afk = false,
        ?int $since = null
    ): void {
        $presenceUpdate = [
            'status' => $status->value,
            'activities' => array_map(fn (ActivityBuilder $builder) => $builder->get(), $activities),
            'afk' => $afk,
        ];

        if (!is_null($since)) {
            $presenceUpdate['since'] = $since;
        }

        $this->sendPayload(['op' => 3, 'd' => $presenceUpdate]);
    }

     public function resume(string $token, string $sessionId, ?int $sequence = null): void
     {
         $this->sendPayload([
             'op' => 6,
             'd' => [
                 'token' => $token,
                 'session_id' => $sessionId,
                 'seq' => $sequence,
             ]
         ]);
     }

     /**
     * @see https://discord.com/developers/docs/topics/gateway-events#request-guild-members
     */
    public function requestGuildMembersByQuery(
        string $guildId,
        string $query = '',
        int $limit = 0,
        bool $presences = false,
        ?string $nonce = null
    ): void {
        $guildMemberRequest = [
            'guild_id' => $guildId,
            'query' => $query,
            'limit' => $limit,
            'presences' => $presences,
        ];

        if (!is_null($nonce)) {
            $guildMemberRequest['nonce'] = $nonce;
        }

        $this->sendPayload(['op' => 8, 'd' => $guildMemberRequest]);
    }

    /**
     * @see https://discord.com/developers/docs/topics/gateway-events#request-guild-members
     */
    public function requestGuildMembersByUserIds(
        string $guildId,
        array $userIds,
        int $limit = 0,
        bool $presences = false,
        ?string $nonce = null
    ): void {
        $guildMemberRequest = [
            'guild_id' => $guildId,
            'user_ids' => $userIds,
            'limit' => $limit,
            'presences' => $presences,
        ];

        if (!is_null($nonce)) {
            $guildMemberRequest['nonce'] = $nonce;
        }

        $this->sendPayload(['op' => 8, 'd' => $guildMemberRequest]);
    }

    private function sendPayload(array $data, bool $useBucket = true): void
    {
        $this->websocket->send(json_encode($data), $useBucket);
    }
}
