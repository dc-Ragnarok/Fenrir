<?php

declare(strict_types=1);

namespace Tests\Exan\Finrir\Rest\Helpers\Channel;

use Exan\Finrir\Rest\Helpers\Channel\InviteBuilder;
use PHPUnit\Framework\TestCase;

class InviteBuilderTest extends TestCase
{
    public function testCanSetMaxAge()
    {
        $builder = new InviteBuilder();
        $builder->setMaxAge(3600);
        $this->assertEquals(3600, $builder->get()['max_age']);

        $builder->setMaxAge(-1);
        $this->assertEquals(0, $builder->get()['max_age']);

        $builder->setMaxAge(604801);
        $this->assertEquals(604800, $builder->get()['max_age']);
    }

    public function testCanSetMaxUses()
    {
        $builder = new InviteBuilder();
        $builder->setMaxUses(5);
        $this->assertEquals(5, $builder->get()['max_uses']);

        $builder->setMaxUses(-1);
        $this->assertEquals(0, $builder->get()['max_uses']);

        $builder->setMaxUses(101);
        $this->assertEquals(100, $builder->get()['max_uses']);
    }

    public function testCanSetTemporary()
    {
        $builder = new InviteBuilder();
        $builder->setTemporary(true);
        $this->assertArrayHasKey('temporary', $builder->get());
        $this->assertEquals(true, $builder->get()['temporary']);
    }

    public function testCanSetUnique()
    {
        $builder = new InviteBuilder();
        $builder->setUnique(true);
        $this->assertArrayHasKey('unique', $builder->get());
        $this->assertEquals(true, $builder->get()['unique']);
    }

    public function testCanSetTargetType()
    {
        $builder = new InviteBuilder();
        $builder->setTargetType(1);
        $this->assertArrayHasKey('target_type', $builder->get());
        $this->assertEquals(1, $builder->get()['target_type']);
    }

    public function testCanSetTargetUserId()
    {
        $builder = new InviteBuilder();
        $builder->setTargetUserId('12345');
        $this->assertArrayHasKey('target_user_id', $builder->get());
        $this->assertEquals('12345', $builder->get()['target_user_id']);
    }

    public function testCanSetTargetApplicationId()
    {
        $builder = new InviteBuilder();
        $builder->setTargetApplicationId('67890');
        $this->assertArrayHasKey('target_application_id', $builder->get());
        $this->assertEquals('67890', $builder->get()['target_application_id']);
    }
}
