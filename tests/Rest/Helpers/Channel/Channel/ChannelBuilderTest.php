<?php

namespace Tests\Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

use Exan\Dhp\Parts\Overwrite;
use Exan\Dhp\Enums\Parts\OverwriteTypes;
use Exan\Dhp\Rest\Helpers\Channel\Channel\ChannelBuilder;
use PHPUnit\Framework\TestCase;

class ChannelBuilderTest extends TestCase
{
    private function getBuilder(): ChannelBuilder
    {
        return new class extends ChannelBuilder {
        };
    }

    public function testSetName()
    {
        $builder = $this->getBuilder();
        $builder->setName('::name::');

        $this->assertEquals('::name::', $builder->get()['name']);
    }

    public function testSetPosition()
    {
        $builder = $this->getBuilder();
        $builder->setPosition(1);

        $this->assertEquals(1, $builder->get()['position']);
    }

    public function testAddPermissionOverwrites()
    {
        $overwrite = new Overwrite(OverwriteTypes::MEMBER);
        $builder = $this->getBuilder();
        $builder->addPermissionOverwrites($overwrite);

        $this->assertEquals([$overwrite->toArray()], $builder->get()['permission_overwrites']);
    }
}
