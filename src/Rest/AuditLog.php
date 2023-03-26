<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest;

use Discord\Http\Endpoint;
use Exan\Fenrir\Parts\AuditLog as PartsAuditLog;
use Exan\Fenrir\Rest\Helpers\AuditLog\GetGuildAuditLogsBuilder;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/audit-log
 */
class AuditLog extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/audit-log#get-guild-audit-log
     *
     * @return ExtendedPromiseInterface<\Exan\Fenrir\Parts\AuditLog>
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
