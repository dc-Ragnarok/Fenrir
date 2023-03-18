<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\Channel;

use Discord\Http\Multipart\MultipartBody;
use Exan\Fenrir\Component\Button\DangerButton;
use Exan\Fenrir\Exceptions\Rest\Helpers\MessageBuilder\TooManyStickersException;
use Exan\Fenrir\Rest\Helpers\Channel\AllowedMentionsBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\AttachmentBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\ComponentBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\ComponentRowBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\EmbedBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\MessageBuilder;
use PHPUnit\Framework\TestCase;

class MessageBuilderTest extends TestCase
{
    public function testSetNonce()
    {
        $builder = new MessageBuilder();
        $builder->setNonce('::nonce::');
        $this->assertEquals('::nonce::', $builder->get()['nonce']);
        $this->assertEquals('::nonce::', $builder->getNonce());
    }

    public function testSetTts()
    {
        $builder = new MessageBuilder();
        $builder->setTts(true);
        $this->assertTrue($builder->get()['tts']);
        $this->assertTrue($builder->getTts());
    }

    public function testSetReference()
    {
        $builder = new MessageBuilder();
        $builder->setReference(
            '::reference channel::',
            '::reference message::',
            true,
            '::reference guild::'
        );

        $reference = $builder->get()['message_reference'];
        $this->assertEquals('::reference channel::', $reference['channel_id']);
        $this->assertEquals('::reference message::', $reference['message_id']);
        $this->assertTrue($reference['fail_if_not_exists']);
        $this->assertEquals('::reference guild::', $reference['guild_id']);
        $this->assertEquals($reference, $builder->getReference());
    }

    public function testAddSticker()
    {
        $builder = new MessageBuilder();
        $builder->addSticker('::sticker id::');
        $this->assertEquals(['::sticker id::'], $builder->get()['stickers']);
        $this->assertEquals(['::sticker id::'], $builder->getStickers());
    }

    public function testAddStickerThrowsException()
    {
        $builder = new MessageBuilder();

        foreach (range(1, 3) as $count) {
            $builder->addSticker('::sticker id ' . $count . '::');
        }

        $this->expectException(TooManyStickersException::class);

        $builder->addSticker('::sticker id 4::');
    }

    public function testRequiresMultipart()
    {
        $builder = new MessageBuilder();

        $builder->addFile(
            'file',
            '::spooky binary data::',
        );

        $this->assertEquals(true, $builder->requiresMultipart());
    }

    public function testGetMultipart()
    {
        $builder = new MessageBuilder();

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

    public function testGetAttachments()
    {
        $messageBuilder = MessageBuilder::new();

        $attachment = AttachmentBuilder::new()
            ->setFilename('::filename::');

        $messageBuilder->addAttachment($attachment);

        $this->assertEquals([$attachment->get()], $messageBuilder->get()['attachments']);
    }

    public function testGetComponents()
    {
        $messageBuilder = MessageBuilder::new();

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
        $messageBuilder = MessageBuilder::new();

        $embed = EmbedBuilder::new()
            ->setTitle('::title::');

        $messageBuilder->addEmbed($embed);

        $this->assertEquals([$embed->get()], $messageBuilder->get()['embeds']);
    }

    public function testGetAllowedMentions()
    {
        $messageBuilder = MessageBuilder::new();

        $allowedMentions = AllowedMentionsBuilder::new()
            ->allowUsers('::user id::');

        $messageBuilder->allowMentions($allowedMentions);

        $this->assertEquals($allowedMentions->get(), $messageBuilder->get()['allowed_mentions']);
    }
}
