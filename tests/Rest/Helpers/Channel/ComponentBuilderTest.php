<?php

declare(strict_types=1);

namespace Tests\Exan\Finrir\Rest\Helpers\Channel;

use Exan\Finrir\Exceptions\Rest\Helpers\ComponentBuilder\TooManyRowsException;
use Exan\Finrir\Rest\Helpers\Channel\ComponentBuilder;
use Exan\Finrir\Rest\Helpers\Channel\ComponentRowBuilder;
use Mockery;
use PHPUnit\Framework\TestCase;

class ComponentBuilderTest extends TestCase
{
    public function testAddRow()
    {
        $componentRow = Mockery::mock(ComponentRowBuilder::class);
        $componentRow->shouldReceive('get')->andReturn(['::row::']);

        $componentBuilder = (new ComponentBuilder())->addRow($componentRow);

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
