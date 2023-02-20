<?php

declare(strict_types=1);

namespace Tests\Exan\Finrir\Rest;

use Exan\Finrir\Parts\AuditLog as PartsAuditLog;
use Exan\Finrir\Rest\AuditLog;
use Exan\Finrir\Rest\Helpers\AuditLog\GetGuildAuditLogsBuilder;
use Tests\Exan\Finrir\Rest\HttpHelperTestCase;

class AuditLogTest extends HttpHelperTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->httpItem = new AuditLog($this->http, $this->jsonMapper);
    }

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
