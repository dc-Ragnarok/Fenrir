<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Interaction\Helpers;

use Discord\Http\Multipart\MultipartBody;
use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Component\Button\DangerButton;
use Ragnarok\Fenrir\Enums\InteractionCallbackType;
use Ragnarok\Fenrir\Interaction\Helpers\InteractionCallbackBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\AllowedMentionsBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentRowBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\EmbedBuilder;

class InteractionCallbackBuilderTest extends TestCase
{
    public function testSetType(): void
    {
        $interactionCallbackBuilder = new InteractionCallbackBuilder();

        $interactionCallbackBuilder->setType(InteractionCallbackType::PONG);

        $this->assertEquals(InteractionCallbackType::PONG, $interactionCallbackBuilder->getType());
        $this->assertEquals(InteractionCallbackType::PONG->value, $interactionCallbackBuilder->get()['type']);
    }

    public function testGetMultipart(): void
    {
        $interactionCallbackBuilder = new InteractionCallbackBuilder();
        $interactionCallbackBuilder->setType(InteractionCallbackType::PONG);

        $interactionCallbackBuilder->addFile('file.png', '::spoopy binary::');

        $multipart = $interactionCallbackBuilder->get();

        $this->assertInstanceOf(MultipartBody::class, $multipart);
    }

    public function testGetComponents(): void
    {
        $interactionCallbackBuilder = InteractionCallbackBuilder::new()
            ->setType(InteractionCallbackType::CHANNEL_MESSAGE_WITH_SOURCE);

        $component = ComponentBuilder::new()
            ->addRow(
                ComponentRowBuilder::new()
                    ->add(new DangerButton('::custom id::'))
            );

        $interactionCallbackBuilder->setComponents($component);

        $this->assertEquals($component->get(), $interactionCallbackBuilder->get()['data']['components']);
    }

    public function testGetEmbeds(): void
    {
        $interactionCallbackBuilder = InteractionCallbackBuilder::new()
            ->setType(InteractionCallbackType::CHANNEL_MESSAGE_WITH_SOURCE);

        $embed = EmbedBuilder::new()
            ->setTitle('::title::');

        $interactionCallbackBuilder->addEmbed($embed);

        $this->assertEquals([$embed->get()], $interactionCallbackBuilder->get()['data']['embeds']);
    }

    public function testGetAllowedMentions(): void
    {
        $interactionCallbackBuilder = InteractionCallbackBuilder::new()
            ->setType(InteractionCallbackType::CHANNEL_MESSAGE_WITH_SOURCE);

        $allowedMentions = AllowedMentionsBuilder::new()
            ->allowUsers('::user id::');

        $interactionCallbackBuilder->allowMentions($allowedMentions);

        $this->assertEquals($allowedMentions->get(), $interactionCallbackBuilder->get()['data']['allowed_mentions']);
    }
}
