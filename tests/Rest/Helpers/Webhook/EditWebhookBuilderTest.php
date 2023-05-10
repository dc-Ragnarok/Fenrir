<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Webhook;

use Ragnarok\Fenrir\Component\Button\DangerButton;
use Ragnarok\Fenrir\Rest\Helpers\Channel\AllowedMentionsBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\AttachmentBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentRowBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\EmbedBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\EditWebhookBuilder;
use PHPUnit\Framework\TestCase;

class EditWebhookBuilderTest extends TestCase
{
    public function testGetAttachments(): void
    {
        $webhookBuilder = EditWebhookBuilder::new();

        $attachment = AttachmentBuilder::new()
            ->setFilename('::filename::');

        $webhookBuilder->addAttachment($attachment);

        $this->assertEquals([$attachment->get()], $webhookBuilder->get()['attachments']);
    }

    public function testGetComponents(): void
    {
        $webhookBuilder = EditWebhookBuilder::new();

        $component = ComponentBuilder::new()
            ->addRow(
                ComponentRowBuilder::new()
                    ->add(new DangerButton('::custom id::'))
            );

        $webhookBuilder->setComponents($component);

        $this->assertEquals($component->get(), $webhookBuilder->get()['components']);
    }

    public function testGetEmbeds(): void
    {
        $webhookBuilder = EditWebhookBuilder::new();

        $embed = EmbedBuilder::new()
            ->setTitle('::title::');

        $webhookBuilder->addEmbed($embed);

        $this->assertEquals([$embed->get()], $webhookBuilder->get()['embeds']);
    }

    public function testGetAllowedMentions(): void
    {
        $webhookBuilder = EditWebhookBuilder::new();

        $allowedMentions = AllowedMentionsBuilder::new()
            ->allowUsers('::user id::');

        $webhookBuilder->allowMentions($allowedMentions);

        $this->assertEquals($allowedMentions->get(), $webhookBuilder->get()['allowed_mentions']);
    }

    public function testRequiresMultipart(): void
    {
        $builder = new EditWebhookBuilder();

        $builder->addFile(
            'file',
            '::spooky binary data::',
        );

        $this->assertTrue($builder->requiresMultipart());
    }

    public function testGetMultipart(): void
    {
        $builder = new EditWebhookBuilder();

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
}
