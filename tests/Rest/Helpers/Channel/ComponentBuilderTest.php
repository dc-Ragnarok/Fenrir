<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Exceptions\Rest\Helpers\ComponentBuilder\TooManyRowsException;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentRowBuilder;
use Mockery;
use PHPUnit\Framework\TestCase;

class ComponentBuilderTest extends TestCase
{
    public function testAddRow()
    {
        $componentRow = Mockery::mock(ComponentRowBuilder::class);
        $componentRow->shouldReceive('get')->andReturn(['::row::']);

        $componentBuilder = new ComponentBuilder();

        $this->assertEquals([], $componentBuilder->getRows());

        $componentBuilder->addRow($componentRow);

        $this->assertEquals([$componentRow], $componentBuilder->getRows());

        $this->assertEquals([[
            'type' => 1,
            'components' => ['::row::'],
        ]], $componentBuilder->get());
    }

    public function testItThrowsAnErrorWithTooManyRows()
    {
        $componentRow = Mockery::mock(ComponentRowBuilder::class);
        $componentRow->shouldReceive('get')->andReturn(['::row::']);

        $componentBuilder = new ComponentBuilder();

        foreach (range(1, 5) as $count) {
            $componentBuilder->addRow($componentRow);
        }

        $this->expectException(TooManyRowsException::class);
        $componentBuilder->addRow($componentRow);
    }
}
