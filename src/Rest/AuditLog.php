<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Exan\Dhp\Parts\AuditLog as PartsAuditLog;
use Exan\Dhp\Rest\Helpers\AuditLog\GetGuildAuditLogsBuilder;
use Exan\Dhp\Rest\Helpers\HttpHelper;
use JsonMapper;
use React\Promise\ExtendedPromiseInterface;

class AuditLog
{
    use HttpHelper;

    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/audit-log#get-guild-audit-log
     *
     * @return ExtendedPromiseInterface<\Exan\Dhp\Parts\AuditLog>
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
