<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\Channel;

use Exan\Fenrir\Component\Button\DangerButton;
use Exan\Fenrir\Rest\Helpers\Channel\AllowedMentionsBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\AttachmentBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\ComponentBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\ComponentRowBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\EditMessageBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\EmbedBuilder;
use PHPUnit\Framework\TestCase;

class EditMessageBuilderTest extends TestCase
{
    public function testGetAttachments()
    {
        $messageBuilder = EditMessageBuilder::new();

        $attachment = AttachmentBuilder::new()
            ->setFilename('::filename::');

        $messageBuilder->addAttachment($attachment);

        $this->assertEquals([$attachment->get()], $messageBuilder->get()['attachments']);
    }

    public function testGetComponents()
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

    public function testGetEmbeds()
    {
        $messageBuilder = EditMessageBuilder::new();

        $embed = EmbedBuilder::new()
            ->setTitle('::title::');

        $messageBuilder->addEmbed($embed);

        $this->assertEquals([$embed->get()], $messageBuilder->get()['embeds']);
    }

    public function testGetAllowedMentions()
    {
        $messageBuilder = EditMessageBuilder::new();

        $allowedMentions = AllowedMentionsBuilder::new()
            ->allowUsers('::user id::');

        $messageBuilder->allowMentions($allowedMentions);

        $this->assertEquals($allowedMentions->get(), $messageBuilder->get()['allowed_mentions']);
    }
}
