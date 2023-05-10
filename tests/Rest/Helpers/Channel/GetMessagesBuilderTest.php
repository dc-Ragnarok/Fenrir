<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Rest\Helpers\Channel\GetMessagesBuilder;
use PHPUnit\Framework\TestCase;

class GetMessagesBuilderTest extends TestCase
{
    public function testSetAround(): void
    {
        $builder = new GetMessagesBuilder();
        $builder->setAround('::around::');

        $this->assertEquals(['around' => '::around::'], $builder->get());
        $this->assertEquals('::around::', $builder->getAround());
    }

    public function testSetBefore(): void
    {
        $builder = new GetMessagesBuilder();
        $builder->setBefore('::before::');

        $this->assertEquals(['before' => '::before::'], $builder->get());
        $this->assertEquals('::before::', $builder->getBefore());
    }

    public function testSetAfter(): void
    {
        $builder = new GetMessagesBuilder();
        $builder->setAfter('::after::');

        $this->assertEquals(['after' => '::after::'], $builder->get());
        $this->assertEquals('::after::', $builder->getAfter());
    }

    public function testSetLimit(): void
    {
        $builder = new GetMessagesBuilder();
        $builder->setLimit(50);

        $this->assertEquals(['limit' => 50], $builder->get());
        $this->assertEquals(50, $builder->getLimit());
    }

    public function testSetLimitGreaterThan100(): void
    {
        $builder = new GetMessagesBuilder();
        $builder->setLimit(150);

        $this->assertEquals(['limit' => 100], $builder->get());
        $this->assertEquals(100, $builder->getLimit());
    }

    public function testSetLimitLowerThan1(): void
    {
        $builder = new GetMessagesBuilder();
        $builder->setLimit(-50);

        $this->assertEquals(['limit' => 1], $builder->get());
        $this->assertEquals(1, $builder->getLimit());
    }
}
