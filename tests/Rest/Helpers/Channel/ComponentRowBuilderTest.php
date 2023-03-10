<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\Channel;

use Exan\Fenrir\Component\Component;
use Exan\Fenrir\Exceptions\Rest\Helpers\ComponentRowBuilder\TooManyItemsException;
use Exan\Fenrir\Rest\Helpers\Channel\ComponentRowBuilder;
use PHPUnit\Framework\TestCase;

class ComponentRowBuilderTest extends TestCase
{
    public function testGetComponentRow()
    {
        $component = new class () extends Component {
            public function get(): array
            {
                return ['::component::'];
            }
        };

        $componentRow = (new ComponentRowBuilder())->add($component);

        $this->assertEquals([
            ['::component::'],
        ], $componentRow->get());
    }

    public function testItThrowsAnErrorOnTooManyComponents()
    {
        $component = new class () extends Component {
            public function get(): array
            {
                return ['::component::'];
            }
        };

        $componentRow = new ComponentRowBuilder();

        foreach (range(1, 9) as $count) {
            $componentRow->add($component);
        }

        $this->expectException(TooManyItemsException::class);

        $componentRow->add($component);
    }
}
