<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Webhook;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Component\Button\DangerButton;
use Ragnarok\Fenrir\Rest\Helpers\Channel\AllowedMentionsBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\AttachmentBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentRowBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\EmbedBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\EditWebhookMessageBuilder;

class EditWebhookMessageBuilderTest extends TestCase
{
    public function testRequiresMultipart(): void
    {
        $builder = new EditWebhookMessageBuilder();

        $builder->addFile(
            'file',
            '::spooky binary data::',
        );

        $this->assertTrue($builder->requiresMultipart());
    }

    public function testGetMultipart(): void
    {
        $builder = new EditWebhookMessageBuilder();

        $builder->setContent('::content::');

        $builder->addFile(
            'file',
            '::spooky binary data::',
        );

        $builder->addFile(
            'file.jpg',
            '::spooky binary data::',
        );

        /** @var MultipartBody */
        $multipart = $builder->get();

        $body = (string) $multipart;

        $this->assertStringContainsString(json_encode(['content' => '::content::']), $body);
        $this->assertStringContainsString('filename="file"', $body);
        $this->assertStringContainsString('filename="file.jpg"', $body);
        $this->assertStringContainsString('::spooky binary data::', $body);
        $this->assertStringContainsString('Content-Type: image/jpeg', $body);
    }

    public function testGetAttachments(): void
    {
        $messageBuilder = EditWebhookMessageBuilder::new();

        $attachment = AttachmentBuilder::new()
            ->setFilename('::filename::');

        $messageBuilder->addAttachment($attachment);

        $this->assertEquals([$attachment->get()], $messageBuilder->get()['attachments']);
    }

    public function testGetComponents(): void
    {
        $messageBuilder = EditWebhookMessageBuilder::new();

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
        $messageBuilder = EditWebhookMessageBuilder::new();

        $embed = EmbedBuilder::new()
            ->setTitle('::title::');

        $messageBuilder->addEmbed($embed);

        $this->assertEquals([$embed->get()], $messageBuilder->get()['embeds']);
    }

    public function testGetAllowedMentions(): void
    {
        $messageBuilder = EditWebhookMessageBuilder::new();

        $allowedMentions = AllowedMentionsBuilder::new()
            ->allowUsers('::user id::');

        $messageBuilder->allowMentions($allowedMentions);

        $this->assertEquals($allowedMentions->get(), $messageBuilder->get()['allowed_mentions']);
    }
}
