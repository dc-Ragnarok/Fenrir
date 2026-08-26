<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Interaction;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Gateway\Events\InteractionCreate;
use Ragnarok\Fenrir\Interaction\ModalSubmitInteraction;
use Psr\Log\NullLogger;

class ModalSubmitInteractionTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private function interaction(array $data): ModalSubmitInteraction
    {
        $mapper = new DataMapper(new NullLogger());

        return new ModalSubmitInteraction(
            $mapper->map((object) ['data' => (object) $data], InteractionCreate::class),
            Mockery::mock(Discord::class)
        );
    }

    /**
     * The classic shape: text inputs wrapped in action rows.
     */
    public function testItReadsFieldsNestedInActionRows(): void
    {
        $interaction = $this->interaction([
            'custom_id' => 'feedback',
            'components' => [
                (object) ['type' => 1, 'components' => [
                    (object) ['type' => 4, 'custom_id' => 'title', 'value' => 'A bug'],
                ]],
                (object) ['type' => 1, 'components' => [
                    (object) ['type' => 4, 'custom_id' => 'body', 'value' => 'It broke'],
                ]],
            ],
        ]);

        $this->assertEquals('feedback', $interaction->getCustomId());
        $this->assertEquals(['title' => 'A bug', 'body' => 'It broke'], $interaction->getValues());
        $this->assertEquals('A bug', $interaction->getValue('title'));
        $this->assertTrue($interaction->hasValue('body'));
    }

    /**
     * The newer shape nests each input under a label instead, so the payload is
     * walked rather than assumed to be a fixed two levels deep.
     */
    public function testItReadsFieldsNestedInLabels(): void
    {
        $interaction = $this->interaction([
            'custom_id' => 'feedback',
            'components' => [
                (object) ['type' => 18, 'component' => (object) [
                    'type' => 4, 'custom_id' => 'title', 'value' => 'A bug',
                ]],
            ],
        ]);

        $this->assertEquals(['title' => 'A bug'], $interaction->getValues());
    }

    public function testAnUnknownFieldIsNull(): void
    {
        $interaction = $this->interaction(['custom_id' => 'feedback', 'components' => []]);

        $this->assertNull($interaction->getValue('nope'));
        $this->assertFalse($interaction->hasValue('nope'));
        $this->assertEquals([], $interaction->getValues());
    }

    public function testAModalWithNoComponentsAtAllIsSafe(): void
    {
        $this->assertEquals([], $this->interaction(['custom_id' => 'empty'])->getValues());
    }
}
