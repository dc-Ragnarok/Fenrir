<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Interaction\Helpers;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Component\Modal\Label;
use Ragnarok\Fenrir\Component\TextInput;
use Ragnarok\Fenrir\Enums\InteractionCallbackType;
use Ragnarok\Fenrir\Enums\TextInputStyle;
use Ragnarok\Fenrir\Interaction\Helpers\InteractionCallbackBuilder;
use Ragnarok\Fenrir\Interaction\Helpers\ModalBuilder;

class ModalBuilderTest extends TestCase
{
    private function modal(): ModalBuilder
    {
        return ModalBuilder::new()
            ->setCustomId('feedback')
            ->setTitle('Send feedback')
            ->add(new Label('Title', new TextInput('title', TextInputStyle::Short, 'Title')))
            ->add(new Label('Details', new TextInput('body', TextInputStyle::Paragraph, 'Details')));
    }

    public function testItBuildsTheModalPayload(): void
    {
        $built = $this->modal()->get();

        $this->assertEquals('feedback', $built['custom_id']);
        $this->assertEquals('Send feedback', $built['title']);
        $this->assertCount(2, $built['components']);
        $this->assertEquals(18, $built['components'][0]['type']);
        $this->assertEquals('title', $built['components'][0]['component']['custom_id']);
    }

    public function testGettersReturnNullWhenUnset(): void
    {
        $modal = ModalBuilder::new();

        $this->assertNull($modal->getCustomId());
        $this->assertNull($modal->getTitle());
        $this->assertEquals([], $modal->getComponents());
    }

    /**
     * A modal cannot be sent as any other kind of response, so setting one also
     * settles the callback type.
     */
    public function testSettingAModalSelectsTheCallbackType(): void
    {
        $callback = InteractionCallbackBuilder::new()->setModal($this->modal());

        $this->assertEquals(InteractionCallbackType::MODAL, $callback->getType());

        $built = $callback->get();

        $this->assertEquals(InteractionCallbackType::MODAL->value, $built['type']);
        $this->assertEquals('feedback', $built['data']['custom_id']);
        $this->assertCount(2, $built['data']['components']);
    }

    /**
     * The message oriented fields on the callback builder have no meaning in a
     * modal response and must not leak into it.
     */
    public function testMessageFieldsDoNotLeakIntoAModalResponse(): void
    {
        $built = InteractionCallbackBuilder::new()
            ->setContent('::ignored::')
            ->setModal($this->modal())
            ->get();

        $this->assertArrayNotHasKey('content', $built['data']);
        $this->assertEquals(['custom_id', 'title', 'components'], array_keys($built['data']));
    }
}
