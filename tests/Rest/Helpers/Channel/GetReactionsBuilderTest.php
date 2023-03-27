<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Rest\Helpers\Channel\GetReactionsBuilder;
use Monolog\Test\TestCase;

class GetReactionsBuilderTest extends TestCase
{
    public function testSetAfter()
    {
        $builder = new GetReactionsBuilder();
        $builder->setAfter('::after::');

        $this->assertEquals(['after' => '::after::'], $builder->get());
        $this->assertEquals('::after::', $builder->getAfter());
    }

    public function testSetLimit()
    {
        $builder = new GetReactionsBuilder();
        $builder->setLimit(25);

        $this->assertEquals(['limit' => 25], $builder->get());
        $this->assertEquals(25, $builder->getLimit());
    }

    public function testSetLimitGreaterThan100()
    {
        $builder = new GetReactionsBuilder();
        $builder->setLimit(150);

        $this->assertEquals(['limit' => 100], $builder->get());
        $this->assertEquals(100, $builder->getLimit());
    }

    public function testSetLimitLowerThan1()
    {
        $builder = new GetReactionsBuilder();
        $builder->setLimit(-50);

        $this->assertEquals(['limit' => 1], $builder->get());
        $this->assertEquals(1, $builder->getLimit());
    }
}
