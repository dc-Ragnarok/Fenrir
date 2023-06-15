<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Guild;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Rest\Helpers\Guild\ModifyChannelPositionsBuilder;

class ModifyChannelPositionsBuilderTest extends TestCase
{
    public function testId(): void
    {
        $builder = new ModifyChannelPositionsBuilder();

        $this->assertNull($builder->getId());

        $id = '123456789';
        $builder->setId($id);

        $this->assertSame($id, $builder->getId());
    }

    public function testPosition(): void
    {
        $builder = new ModifyChannelPositionsBuilder();

        $this->assertNull($builder->getPosition());

        $position = 34;
        $builder->setPosition($position);

        $this->assertSame($position, $builder->getPosition());
    }

    public function testLockPermissions(): void
    {
        $builder = new ModifyChannelPositionsBuilder();

        $this->assertNull($builder->getLockPermissions());

        $lockPermissions = true;
        $builder->setLockPermissions($lockPermissions);

        $this->assertSame($lockPermissions, $builder->getLockPermissions());
    }

    public function testParentId(): void
    {
        $builder = new ModifyChannelPositionsBuilder();

        $this->assertNull($builder->getParentId());

        $parentId = '987654321';
        $builder->setParentId($parentId);

        $this->assertSame($parentId, $builder->getParentId());
    }
}
