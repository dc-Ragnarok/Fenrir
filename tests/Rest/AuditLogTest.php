<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest;

use Exan\Fenrir\Parts\AuditLog as PartsAuditLog;
use Exan\Fenrir\Rest\AuditLog;
use Exan\Fenrir\Rest\Helpers\AuditLog\GetGuildAuditLogsBuilder;
use Tests\Exan\Fenrir\Rest\HttpHelperTestCase;

class AuditLogTest extends HttpHelperTestCase
{
    protected string $httpItemClass = AuditLog::class;

    public function httpBindingsProvider(): array
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
