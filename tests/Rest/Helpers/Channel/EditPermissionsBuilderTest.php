<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Rest\Helpers\Channel\EditPermissionsBuilder;

class EditPermissionsBuilderTest extends TestCase
{
    public function testOverwriteIdIsNullWhenNoneSet(): void
    {
        $this->assertNull(EditPermissionsBuilder::new()->getOverwriteId());
    }

    public function testSetMemberId(): void
    {
        $builder = EditPermissionsBuilder::new()
            ->setMemberId('::member id::');

        $this->assertEquals('::member id::', $builder->getOverwriteId());
        $this->assertEquals(1, $builder->get()['type']);
    }

    public function testSetRoleId(): void
    {
        $builder = EditPermissionsBuilder::new()
            ->setRoleId('::role id::');

        $this->assertEquals('::role id::', $builder->getOverwriteId());
        $this->assertEquals(0, $builder->get()['type']);
    }

    public function testSetAllow(): void
    {
        $builder = EditPermissionsBuilder::new();

        $this->assertNull($builder->getAllow());

        $bitwise = new Bitwise(
            1 << 1,
            1 << 2,
            1 << 3
        );

        $builder->setAllow($bitwise);

        $this->assertEquals($bitwise->get(), $builder->getAllow()->get());
    }

    public function testSetDeny(): void
    {
        $builder = EditPermissionsBuilder::new();

        $this->assertNull($builder->getDeny());

        $bitwise = new Bitwise(
            1 << 1,
            1 << 2,
            1 << 3
        );

        $builder->setDeny($bitwise);

        $this->assertEquals($bitwise->get(), $builder->getDeny()->get());
    }
}
