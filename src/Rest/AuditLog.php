<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Ragnarok\Fenrir\Parts\AuditLog as PartsAuditLog;
use Ragnarok\Fenrir\Rest\Helpers\AuditLog\GetGuildAuditLogsBuilder;
use Ragnarok\Fenrir\Rest\Helpers\HttpHelper;
use JsonMapper;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/audit-log
 */
class AuditLog
{
    use HttpHelper;

    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/audit-log#get-guild-audit-log
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\AuditLog>
     */
    public function getGuildAuditLogs(
        string $guildId,
        GetGuildAuditLogsBuilder $getGuildAuditLogsBuilder
    ): ExtendedPromiseInterface {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::AUDIT_LOG,
                    $guildId
                ),
                $getGuildAuditLogsBuilder->get()
            ),
            PartsAuditLog::class
        );
    }
}
