<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\AuditLog as PartsAuditLog;
use Ragnarok\Fenrir\Rest\Helpers\AuditLog\GetGuildAuditLogsBuilder;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/audit-log
 */
class AuditLog extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/audit-log#get-guild-audit-log
     *
     * @return ExtendedPromiseInterface<PartsAuditLog>
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
        )->otherwise($this->logThrowable(...));
    }
}
