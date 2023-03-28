<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Webhook;

use Ragnarok\Fenrir\Component\Button\DangerButton;
use Ragnarok\Fenrir\Rest\Helpers\Channel\AllowedMentionsBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\AttachmentBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentRowBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\EmbedBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\WebhookBuilder;
use PHPUnit\Framework\TestCase;

class WebhookBuilderTest extends TestCase
{
    public function testSetUsername(): void
    {
        $webhookBuilder = WebhookBuilder::new()
            ->setUsername('::username::');

        $this->assertEquals('::username::', $webhookBuilder->get()['username']);
        $this->assertEquals('::username::', $webhookBuilder->getUsername());
    }

    public function testSetAvatarUrl(): void
    {
        $webhookBuilder = WebhookBuilder::new()
            ->setAvatarUrl('::url::');

        $this->assertEquals('::url::', $webhookBuilder->get()['avatar_url']);
        $this->assertEquals('::url::', $webhookBuilder->getAvatarUrl());
    }

    public function testSetThreadName(): void
    {
        $webhookBuilder = WebhookBuilder::new()
            ->setThreadName('::thread name::');

        $this->assertEquals('::thread name::', $webhookBuilder->get()['thread_name']);
        $this->assertEquals('::thread name::', $webhookBuilder->getThreadName());
    }

    public function testGetAttachments(): void
    {
        $webhookBuilder = WebhookBuilder::new();

        $attachment = AttachmentBuilder::new()
            ->setFilename('::filename::');

        $webhookBuilder->addAttachment($attachment);

        $this->assertEquals([$attachment->get()], $webhookBuilder->get()['attachments']);
    }

    public function testGetComponents(): void
    {
        $webhookBuilder = WebhookBuilder::new();

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
        $webhookBuilder = WebhookBuilder::new();

        $embed = EmbedBuilder::new()
            ->setTitle('::title::');

        $webhookBuilder->addEmbed($embed);

        $this->assertEquals([$embed->get()], $webhookBuilder->get()['embeds']);
    }

    public function testGetAllowedMentions(): void
    {
        $webhookBuilder = WebhookBuilder::new();

        $allowedMentions = AllowedMentionsBuilder::new()
            ->allowUsers('::user id::');

        $webhookBuilder->allowMentions($allowedMentions);

        $this->assertEquals($allowedMentions->get(), $webhookBuilder->get()['allowed_mentions']);
    }

    public function testRequiresMultipart(): void
    {
        $builder = new WebhookBuilder();

        $builder->addFile(
            'file',
            '::spooky binary data::',
        );

        $this->assertEquals(true, $builder->requiresMultipart());
    }

    public function testGetMultipart(): void
    {
        $builder = new WebhookBuilder();

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
