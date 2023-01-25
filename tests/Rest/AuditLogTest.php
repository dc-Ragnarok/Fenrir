<?php

declare(strict_types=1);

use Exan\Dhp\Parts\AuditLog as PartsAuditLog;
use Exan\Dhp\Rest\AuditLog;
use Exan\Dhp\Rest\Helpers\AuditLog\GetGuildAuditLogsBuilder;
use Tests\Exan\Dhp\Rest\HttpHelperTestCase;

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
