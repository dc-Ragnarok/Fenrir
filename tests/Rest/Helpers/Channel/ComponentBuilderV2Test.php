<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Component\Button\PrimaryButton;
use Ragnarok\Fenrir\Component\V2\Container;
use Ragnarok\Fenrir\Component\V2\TextDisplay;
use Ragnarok\Fenrir\Enums\MessageFlag;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentRowBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\MessageBuilder;

class ComponentBuilderV2Test extends TestCase
{
    /**
     * Rows and top level components can be mixed, and have to come out in the
     * order they were added.
     */
    public function testItKeepsRowsAndComponentsInOrder(): void
    {
        $components = ComponentBuilder::new()
            ->add(new TextDisplay('Above'))
            ->addRow(ComponentRowBuilder::new()->add(new PrimaryButton('::a::')))
            ->add(new TextDisplay('Below'));

        $built = $components->get();

        $this->assertEquals(['type' => 10, 'content' => 'Above'], $built[0]);
        $this->assertEquals(1, $built[1]['type']);
        $this->assertEquals(['type' => 10, 'content' => 'Below'], $built[2]);
    }

    public function testGetRowsStillOnlyReturnsRows(): void
    {
        $components = ComponentBuilder::new()
            ->add(new TextDisplay('Above'))
            ->addRow(ComponentRowBuilder::new())
            ->addRow(ComponentRowBuilder::new());

        $this->assertCount(2, $components->getRows());
        $this->assertCount(3, $components->getComponents());
    }

    public function testAContainerReachesTheMessagePayload(): void
    {
        $message = MessageBuilder::new()
            ->setFlags(MessageFlag::IS_COMPONENTS_V2->value)
            ->setComponents(
                ComponentBuilder::new()->add(
                    new Container()->add(new TextDisplay('Hello'))
                )
            );

        $payload = $message->get();

        $this->assertEquals(MessageFlag::IS_COMPONENTS_V2->value, $payload['flags']);
        $this->assertEquals([
            [
                'type' => 17,
                'components' => [['type' => 10, 'content' => 'Hello']],
            ],
        ], $payload['components']);
    }
}
