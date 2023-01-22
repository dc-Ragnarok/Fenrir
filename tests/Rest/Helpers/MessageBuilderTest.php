<?php

declare(strict_types=1);

use Exan\Dhp\Exceptions\Rest\Helpers\MessageBuilder\TooManyStickersException;
use Exan\Dhp\Rest\Helpers\AllowedMentionsBuilder;
use Exan\Dhp\Rest\Helpers\AttachmentBuilder;
use Exan\Dhp\Rest\Helpers\ComponentBuilder;
use Exan\Dhp\Rest\Helpers\EmbedBuilder;
use Exan\Dhp\Rest\Helpers\MessageBuilder;
use PHPUnit\Framework\TestCase;

class MessageBuilderTest extends TestCase
{
    public function testSetContent()
    {
        $builder = new MessageBuilder();
        $builder->setContent('::content::');
        $this->assertEquals('::content::', $builder->get()['content']);
    }

    public function testSetNonce()
    {
        $builder = new MessageBuilder();
        $builder->setNonce(123456);
        $this->assertEquals(123456, $builder->get()['nonce']);
    }

    public function testSetTts()
    {
        $builder = new MessageBuilder();
        $builder->setTts(true);
        $this->assertTrue($builder->get()['tts']);
    }

    public function testAddEmbed()
    {
        $embedBuilder = new EmbedBuilder();
        $embedBuilder->setTitle('::title::');

        $builder = new MessageBuilder();
        $builder->addEmbed($embedBuilder);
        $this->assertEquals([$embedBuilder->get()], $builder->get()['embeds']);
    }

    public function testAllowMentions()
    {
        $mentionBuilder = new AllowedMentionsBuilder();
        $mentionBuilder->addRole('::role id::');
        $builder = new MessageBuilder();
        $builder->allowMentions($mentionBuilder);
        $this->assertEquals($mentionBuilder->get(), $builder->get()['allowed_mentions']);
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
    }

    public function testAddComponent()
    {
        $componentBuilder = Mockery::mock(ComponentBuilder::class);
        $componentBuilder
            ->shouldReceive('get')
            ->andReturns(['::component::']);

        $builder = new MessageBuilder();
        $builder->addComponent($componentBuilder);
        $this->assertEquals([$componentBuilder->get()], $builder->get()['components']);
    }

    public function testAddSticker()
    {
        $builder = new MessageBuilder();
        $builder->addSticker('::sticker id::');
        $this->assertEquals(['::sticker id::'], $builder->get()['stickers']);
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

    public function testSetFlags()
    {
        $builder = new MessageBuilder();
        $builder->setFlags(1);
        $this->assertEquals(1, $builder->get()['flags']);
    }

    public function testAddFile()
    {
        $builder = new MessageBuilder();

        $builder->addFile(
            'file.jpg',
            '::spooky binary data::',
            '::type::'
        );

        $this->assertEquals(
            [
                'name' => 'file.jpg',
                'content' => '::spooky binary data::',
                'type' => '::type::',
            ],
            $builder->getFiles()[0]
        );
    }

    public function testAddFileAndDetectType()
    {
        $builder = new MessageBuilder();

        $builder->addFile(
            'file.jpg',
            '::spooky binary data::',
        );



        $this->assertEquals(
            [
                'name' => 'file.jpg',
                'content' => '::spooky binary data::',
                'type' => 'image/jpeg',
            ],
            $builder->getFiles()[0]
        );
    }

    public function testAddFileAndDetectTypeThatDoesNotExist()
    {
        $noFileExtensionBuilder = new MessageBuilder();

        $noFileExtensionBuilder->addFile(
            'file',
            '::spooky binary data::',
        );

        $this->assertEquals(
            [
                'name' => 'file',
                'content' => '::spooky binary data::',
            ],
            $noFileExtensionBuilder->getFiles()[0]
        );

        $invalidExtensionBuilder = new MessageBuilder();

        $invalidExtensionBuilder->addFile(
            'file.invalid',
            '::spooky binary data::',
        );

        $this->assertEquals(
            [
                'name' => 'file.invalid',
                'content' => '::spooky binary data::',
            ],
            $invalidExtensionBuilder->getFiles()[0]
        );
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

        $multipart = $builder->getMultipart();

        $body = $multipart->getBody();

        $this->assertStringContainsString(json_encode(['content' => '::content::']), $body);
        $this->assertStringContainsString('filename="file"', $body);
        $this->assertStringContainsString('filename="file.jpg"', $body);
        $this->assertStringContainsString('::spooky binary data::', $body);
        $this->assertStringContainsString('Content-Type: image/jpeg', $body);
    }

    public function testAddAttachment()
    {
        $attachment = new AttachmentBuilder();
        $attachment->setId('1234567890');
        $attachment->setFilename('test.jpg');

        $builder = new MessageBuilder();
        $builder->addAttachment($attachment);

        $this->assertEquals([
            [
                'id' => '1234567890',
                'filename' => 'test.jpg',
            ]
        ], $builder->get()['attachments']);
    }
}
