<?php

namespace Tests\Exan\Dhp\Rest\Helpers\Channel;

use Exan\Dhp\Rest\Helpers\Channel\AllowedMentionsBuilder;
use Exan\Dhp\Rest\Helpers\Channel\AttachmentBuilder;
use Exan\Dhp\Rest\Helpers\Channel\ComponentBuilder;
use Exan\Dhp\Rest\Helpers\Channel\EmbedBuilder;
use Exan\Dhp\Rest\Helpers\Channel\Message\AddAttachment;
use Exan\Dhp\Rest\Helpers\Channel\Message\AddComponent;
use Exan\Dhp\Rest\Helpers\Channel\Message\AddEmbed;
use Exan\Dhp\Rest\Helpers\Channel\Message\AddFile;
use Exan\Dhp\Rest\Helpers\Channel\Message\AllowMentions;
use Exan\Dhp\Rest\Helpers\Channel\Message\SetContent;
use Exan\Dhp\Rest\Helpers\Channel\Message\SetFlags;
use Mockery;
use PHPUnit\Framework\TestCase;

class MessageTraitsTest extends TestCase
{
    public function testSetContent()
    {
        $traitTester = new class {
            use SetContent;

            public $data = [];
        };

        $traitTester->setContent('::content::');

        $this->assertEquals(['content' => '::content::'], $traitTester->data);
    }

    public function testAddEmbed()
    {
        $traitTester = new class {
            use AddEmbed;

            public $data = [];
        };

        $embedBuilder = new EmbedBuilder();
        $embedBuilder->setTitle('::title::');

        $traitTester->addEmbed($embedBuilder);
        $this->assertEquals([$embedBuilder->get()], $traitTester->data['embeds']);
    }

    public function testSetFlags()
    {
        $traitTester = new class {
            use SetFlags;

            public $data = [];
        };

        $traitTester->setFlags(1);
        $this->assertEquals(1, $traitTester->data['flags']);
    }

    public function testAllowMentions()
    {
        $traitTester = new class {
            use AllowMentions;

            public $data = [];
        };

        $mentionBuilder = new AllowedMentionsBuilder();
        $mentionBuilder->addRole('::role id::');

        $traitTester->allowMentions($mentionBuilder);
        $this->assertEquals($mentionBuilder->get(), $traitTester->data['allowed_mentions']);
    }

    public function testAddComponent()
    {
        $traitTester = new class {
            use AddComponent;

            public $data = [];
        };

        $componentBuilder = Mockery::mock(ComponentBuilder::class);
        $componentBuilder
            ->shouldReceive('get')
            ->andReturns(['::component::']);

        $traitTester->addComponent($componentBuilder);
        $this->assertEquals([$componentBuilder->get()], $traitTester->data['components']);
    }

    private function getClassWithAddFileTrait(): object
    {
        return new class {
            use AddFile;

            public $files = [];
        };
    }

    public function testAddFile()
    {
        $traitTester = $this->getClassWithAddFileTrait();

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
            $traitTester->files[0]
        );
    }

    public function testAddFileAndDetectType()
    {
        $traitTester = $this->getClassWithAddFileTrait();

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
            $traitTester->files[0]
        );
    }

    public function testAddFileAndDetectTypeThatDoesNotExist()
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
            $traitTester->files[0]
        );

        $traitTester->files = [];

        $traitTester->addFile(
            'file.invalid',
            '::spooky binary data::',
        );

        $this->assertEquals(
            [
                'name' => 'file.invalid',
                'content' => '::spooky binary data::',
            ],
            $traitTester->files[0]
        );
    }

    public function testAddAttachment()
    {
        $traitTester = new class {
            use AddAttachment;

            public $data = [];
        };

        $attachment = new AttachmentBuilder();
        $attachment->setId('1234567890');
        $attachment->setFilename('test.jpg');

        $traitTester->addAttachment($attachment);

        $this->assertEquals([
            [
                'id' => '1234567890',
                'filename' => 'test.jpg',
            ]
        ], $traitTester->data['attachments']);
    }
}
