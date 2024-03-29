<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Rest\Helpers\Channel\AllowedMentionsBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\AttachmentBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\EmbedBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\AddAttachment;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\AddComponent;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\AddEmbed;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\AddFile;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\AllowMentions;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\SetContent;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\SetFlags;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\SetTts;
use Mockery;
use PHPUnit\Framework\TestCase;

class MessageTraitsTest extends TestCase
{
    public function testSetContent(): void
    {
        $traitTester = new class () {
            use SetContent;

            public $data = [];
        };

        $traitTester->setContent('::content::');

        $this->assertEquals(['content' => '::content::'], $traitTester->data);
        $this->assertEquals('::content::', $traitTester->getContent());
    }

    public function testAddEmbed(): void
    {
        $traitTester = new class () {
            use AddEmbed;
        };

        $this->assertFalse($traitTester->hasEmbeds());

        $embedBuilder = new EmbedBuilder();
        $embedBuilder->setTitle('::title::');

        $traitTester->addEmbed($embedBuilder);
        $this->assertEquals([$embedBuilder], $traitTester->getEmbeds());
        $this->assertTrue($traitTester->hasEmbeds());
    }

    public function testSetFlags(): void
    {
        $traitTester = new class () {
            use SetFlags;

            public $data = [];
        };

        $traitTester->setFlags(1);
        $this->assertEquals(1, $traitTester->data['flags']);
        $this->assertEquals(1, $traitTester->getFlags());
    }

    public function testAllowMentions(): void
    {
        $traitTester = new class () {
            use AllowMentions;
        };

        $this->assertFalse($traitTester->hasAllowedMentions());

        $mentionBuilder = new AllowedMentionsBuilder();
        $mentionBuilder->addRole('::role id::');

        $traitTester->allowMentions($mentionBuilder);
        $this->assertEquals($mentionBuilder, $traitTester->getAllowedMentions());
        $this->assertTrue($traitTester->hasAllowedMentions());
    }

    public function testNoMentions(): void
    {
        $traitTester = new class () {
            use AllowMentions;
        };

        $this->assertFalse($traitTester->hasAllowedMentions());

        $traitTester->noMentions();
        $this->assertEquals(new AllowedMentionsBuilder(), $traitTester->getAllowedMentions());
        $this->assertTrue($traitTester->hasAllowedMentions());
    }

    public function testSetTts(): void
    {
        $traitTester = new class () {
            use SetTts;

            public $data = [];
        };

        $traitTester->setTts(true);

        $this->assertTrue($traitTester->getTts());
        $this->assertTrue($traitTester->data['tts']);
    }

    public function testAddComponent(): void
    {
        $traitTester = new class () {
            use AddComponent;
        };

        $this->assertFalse($traitTester->hasComponents());

        $componentBuilder = Mockery::mock(ComponentBuilder::class);
        $componentBuilder
            ->shouldReceive('get')
            ->andReturns(['::component::']);

        $traitTester->setComponents($componentBuilder);
        $this->assertEquals($componentBuilder, $traitTester->getComponents());
        $this->assertTrue($traitTester->hasComponents());
    }

    private function getClassWithAddFileTrait(): object
    {
        return new class () {
            use AddFile;
        };
    }

    public function testAddFile(): void
    {
        $traitTester = $this->getClassWithAddFileTrait();
        $this->assertFalse($traitTester->hasFiles());

        $traitTester->addFile(
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
            $traitTester->getFiles()[0]
        );
        $this->assertTrue($traitTester->hasFiles());
    }

    public function testAddFileAndDetectType(): void
    {
        $traitTester = $this->getClassWithAddFileTrait();
        $this->assertFalse($traitTester->hasFiles());

        $traitTester->addFile(
            'file.jpg',
            '::spooky binary data::',
        );

        $this->assertEquals(
            [
                'name' => 'file.jpg',
                'content' => '::spooky binary data::',
                'type' => 'image/jpeg',
            ],
            $traitTester->getFiles()[0]
        );
        $this->assertTrue($traitTester->hasFiles());
    }

    public function testAddFileAndDetectTypeThatDoesNotExist(): void
    {
        $traitTester = $this->getClassWithAddFileTrait();

        $traitTester->addFile(
            'file',
            '::spooky binary data::',
        );

        $this->assertEquals(
            [
                'name' => 'file',
                'content' => '::spooky binary data::',
            ],
            $traitTester->getFiles()[0]
        );

        $traitTester = $this->getClassWithAddFileTrait();

        $traitTester->addFile(
            'file.invalid',
            '::spooky binary data::',
        );

        $this->assertEquals(
            [
                'name' => 'file.invalid',
                'content' => '::spooky binary data::',
            ],
            $traitTester->getFiles()[0]
        );
    }

    public function testAddAttachment(): void
    {
        $traitTester = new class () {
            use AddAttachment;
        };

        $this->assertFalse($traitTester->hasAttachments());

        $attachment = new AttachmentBuilder();
        $attachment->setId('1234567890');
        $attachment->setFilename('test.jpg');

        $traitTester->addAttachment($attachment);

        $this->assertEquals([$attachment], $traitTester->getAttachments());
        $this->assertTrue($traitTester->hasAttachments());
    }
}
