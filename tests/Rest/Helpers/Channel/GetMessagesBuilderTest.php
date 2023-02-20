<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\Channel;

use Exan\Fenrir\Rest\Helpers\Channel\GetMessagesBuilder;
use PHPUnit\Framework\TestCase;

class GetMessagesBuilderTest extends TestCase
{
    public function testSetAround()
    {
        $builder = new GetMessagesBuilder();
        $builder->setAround('::around::');

        $this->assertEquals(['around' => '::around::'], $builder->get());
    }

    public function testSetBefore()
    {
        $builder = new GetMessagesBuilder();
        $builder->setBefore('::before::');

        $this->assertEquals(['before' => '::before::'], $builder->get());
    }

    public function testSetAfter()
    {
        $builder = new GetMessagesBuilder();
        $builder->setAfter('::after::');

        $this->assertEquals(['after' => '::after::'], $builder->get());
    }

    public function testSetLimit()
    {
        $builder = new GetMessagesBuilder();
        $builder->setLimit(50);

        $this->assertEquals(['limit' => 50], $builder->get());
    }

    public function testSetLimitGreaterThan100()
    {
        $builder = new GetMessagesBuilder();
        $builder->setLimit(150);

        $this->assertEquals(['limit' => 100], $builder->get());
    }

    public function testSetLimitLowerThan1()
    {
        $builder = new GetMessagesBuilder();
        $builder->setLimit(-50);

        $this->assertEquals(['limit' => 1], $builder->get());
    }
}
