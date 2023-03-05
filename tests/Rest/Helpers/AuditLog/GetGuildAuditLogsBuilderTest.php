<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\AuditLog;

use Exan\Fenrir\Rest\Helpers\AuditLog\GetGuildAuditLogsBuilder;
use PHPUnit\Framework\TestCase;

class GetGuildAuditLogsBuilderTest extends TestCase
{
    public function testCanSetUserId()
    {
        $builder = new GetGuildAuditLogsBuilder();
        $builder->setUserId('::user id::');
        $this->assertArrayHasKey('user_id', $builder->get());
        $this->assertEquals('::user id::', $builder->get()['user_id']);
    }

    public function testCanSetActionType()
    {
        $builder = new GetGuildAuditLogsBuilder();
        $builder->setActionType(123);
        $this->assertArrayHasKey('action_type', $builder->get());
        $this->assertEquals(123, $builder->get()['action_type']);
    }

    public function testCanSetBefore()
    {
        $builder = new GetGuildAuditLogsBuilder();
        $builder->setBefore('::before::');
        $this->assertArrayHasKey('before', $builder->get());
        $this->assertEquals('::before::', $builder->get()['before']);
    }

    public function testCanSetAfter()
    {
        $builder = new GetGuildAuditLogsBuilder();
        $builder->setAfter('::after::');
        $this->assertArrayHasKey('after', $builder->get());
        $this->assertEquals('::after::', $builder->get()['after']);
    }

    public function testCanSetLimit()
    {
        $builder = new GetGuildAuditLogsBuilder();
        $builder->setLimit(-50);
        $this->assertEquals(1, $builder->get()['limit']);

        $builder->setLimit(150);
        $this->assertEquals(100, $builder->get()['limit']);

        $builder->setLimit(50);
        $this->assertEquals(50, $builder->get()['limit']);
    }
}
