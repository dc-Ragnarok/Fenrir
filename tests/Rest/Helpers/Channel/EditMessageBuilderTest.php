<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Component\Button\DangerButton;
use Ragnarok\Fenrir\Rest\Helpers\Channel\AllowedMentionsBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\AttachmentBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentRowBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\EditMessageBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\EmbedBuilder;
use PHPUnit\Framework\TestCase;

class EditMessageBuilderTest extends TestCase
{
    public function testGetAttachments(): void
    {
        $messageBuilder = EditMessageBuilder::new();

        $attachment = AttachmentBuilder::new()
            ->setFilename('::filename::');

        $messageBuilder->addAttachment($attachment);

        $this->assertEquals([$attachment->get()], $messageBuilder->get()['attachments']);
    }

    public function testGetComponents(): void
    {
        $messageBuilder = EditMessageBuilder::new();

        $component = ComponentBuilder::new()
            ->addRow(
                ComponentRowBuilder::new()
                    ->add(new DangerButton('::custom id::'))
            );

        $messageBuilder->setComponents($component);

        $this->assertEquals($component->get(), $messageBuilder->get()['components']);
    }

    public function testGetEmbeds(): void
    {
        $messageBuilder = EditMessageBuilder::new();

        $embed = EmbedBuilder::new()
            ->setTitle('::title::');

        $messageBuilder->addEmbed($embed);

        $this->assertEquals([$embed->get()], $messageBuilder->get()['embeds']);
    }

    public function testGetAllowedMentions(): void
    {
        $messageBuilder = EditMessageBuilder::new();

        $allowedMentions = AllowedMentionsBuilder::new()
            ->allowUsers('::user id::');

        $messageBuilder->allowMentions($allowedMentions);

        $this->assertEquals($allowedMentions->get(), $messageBuilder->get()['allowed_mentions']);
    }
}
