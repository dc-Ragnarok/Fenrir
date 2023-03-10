<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\Webhook;

use Exan\Fenrir\Component\Button\DangerButton;
use Exan\Fenrir\Rest\Helpers\Channel\AllowedMentionsBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\AttachmentBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\ComponentBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\ComponentRowBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\EmbedBuilder;
use Exan\Fenrir\Rest\Helpers\Webhook\WebhookBuilder;
use PHPUnit\Framework\TestCase;

class EditWebhookBuilderTest extends TestCase
{
    public function testGetAttachments()
    {
        $webhookBuilder = WebhookBuilder::new();

        $attachment = AttachmentBuilder::new()
            ->setFilename('::filename::');

        $webhookBuilder->addAttachment($attachment);

        $this->assertEquals([$attachment->get()], $webhookBuilder->get()['attachments']);
    }

    public function testGetComponents()
    {
        $webhookBuilder = WebhookBuilder::new();

        $component = ComponentBuilder::new()
            ->addRow(
                ComponentRowBuilder::new()
                    ->add(new DangerButton('::custom id::'))
            );

        $webhookBuilder->addComponent($component);

        $this->assertEquals([$component->get()], $webhookBuilder->get()['components']);
    }

    public function testGetEmbeds()
    {
        $webhookBuilder = WebhookBuilder::new();

        $embed = EmbedBuilder::new()
            ->setTitle('::title::');

        $webhookBuilder->addEmbed($embed);

        $this->assertEquals([$embed->get()], $webhookBuilder->get()['embeds']);
    }

    public function testGetAllowedMentions()
    {
        $webhookBuilder = WebhookBuilder::new();

        $allowedMentions = AllowedMentionsBuilder::new()
            ->allowUsers('::user id::');

        $webhookBuilder->allowMentions($allowedMentions);

        $this->assertEquals($allowedMentions->get(), $webhookBuilder->get()['allowed_mentions']);
    }

    public function testRequiresMultipart()
    {
        $builder = new WebhookBuilder();

        $builder->addFile(
            'file',
            '::spooky binary data::',
        );

        $this->assertEquals(true, $builder->requiresMultipart());
    }

    public function testGetMultipart()
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
