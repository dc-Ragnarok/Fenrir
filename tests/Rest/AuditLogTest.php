<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest;

use Ragnarok\Fenrir\Parts\AuditLog as PartsAuditLog;
use Ragnarok\Fenrir\Rest\AuditLog;
use Ragnarok\Fenrir\Rest\Helpers\AuditLog\GetGuildAuditLogsBuilder;
use Tests\Ragnarok\Fenrir\Rest\HttpHelperTestCase;

class AuditLogTest extends HttpHelperTestCase
{
    protected string $httpItemClass = AuditLog::class;

    public static function httpBindingsProvider(): array
    {
        return [
            'Get guild audit log' => [
                'method' => 'getGuildAuditLogs',
                'args' => ['::guild id::', new GetGuildAuditLogsBuilder()],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsAuditLog::class
                ]
            ],
        ];
    }
}
