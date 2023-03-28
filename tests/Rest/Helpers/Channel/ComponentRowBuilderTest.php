<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Component\Component;
use Ragnarok\Fenrir\Exceptions\Rest\Helpers\ComponentRowBuilder\TooManyItemsException;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentRowBuilder;
use PHPUnit\Framework\TestCase;

class ComponentRowBuilderTest extends TestCase
{
    public function testGetComponentRow(): void
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

    public function testItThrowsAnErrorOnTooManyComponents(): void
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
