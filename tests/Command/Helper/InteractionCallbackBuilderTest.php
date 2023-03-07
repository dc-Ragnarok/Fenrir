<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Command\Helpers;

use Discord\Http\Multipart\MultipartBody;
use PHPUnit\Framework\TestCase;
use Exan\Fenrir\Command\Helpers\InteractionCallbackBuilder;
use Exan\Fenrir\Component\Button\DangerButton;
use Exan\Fenrir\Enums\Command\InteractionCallbackTypes;
use Exan\Fenrir\Rest\Helpers\Channel\AllowedMentionsBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\ComponentBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\ComponentRowBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\EmbedBuilder;

class InteractionCallbackBuilderTest extends TestCase
{
    public function testSetType()
    {
        $interactionCallbackBuilder = new InteractionCallbackBuilder();

        $interactionCallbackBuilder->setType(InteractionCallbackTypes::PONG);

        $this->assertEquals(InteractionCallbackTypes::PONG, $interactionCallbackBuilder->getType());
        $this->assertEquals(InteractionCallbackTypes::PONG->value, $interactionCallbackBuilder->get()['type']);
    }

    public function testGetMultipart()
    {
        $interactionCallbackBuilder = new InteractionCallbackBuilder();
        $interactionCallbackBuilder->setType(InteractionCallbackTypes::PONG);

        $interactionCallbackBuilder->addFile('file.png', '::spoopy binary::');

        $multipart = $interactionCallbackBuilder->get();

        $this->assertInstanceOf(MultipartBody::class, $multipart);
    }

    public function testGetComponents()
    {
        $interactionCallbackBuilder = InteractionCallbackBuilder::new()
            ->setType(InteractionCallbackTypes::CHANNEL_MESSAGE_WITH_SOURCE);

        $component = ComponentBuilder::new()
            ->addRow(
                ComponentRowBuilder::new()
                    ->add(new DangerButton('::custom id::'))
            );

        $interactionCallbackBuilder->addComponent($component);

        $this->assertEquals([$component->get()], $interactionCallbackBuilder->get()['data']['components']);
    }

    public function testGetEmbeds()
    {
        $interactionCallbackBuilder = InteractionCallbackBuilder::new()
            ->setType(InteractionCallbackTypes::CHANNEL_MESSAGE_WITH_SOURCE);

        $embed = EmbedBuilder::new()
            ->setTitle('::title::');

        $interactionCallbackBuilder->addEmbed($embed);

        $this->assertEquals([$embed->get()], $interactionCallbackBuilder->get()['data']['embeds']);
    }

    public function testGetAllowedMentions()
    {
        $interactionCallbackBuilder = InteractionCallbackBuilder::new()
            ->setType(InteractionCallbackTypes::CHANNEL_MESSAGE_WITH_SOURCE);

        $allowedMentions = AllowedMentionsBuilder::new()
            ->allowUsers('::user id::');

        $interactionCallbackBuilder->allowMentions($allowedMentions);

        $this->assertEquals($allowedMentions->get(), $interactionCallbackBuilder->get()['data']['allowed_mentions']);
    }
}
