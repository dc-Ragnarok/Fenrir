<?php

use Exan\Dhp\Rest\Helpers\AllowedMentionsBuilder;
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

    public function testSetFlags()
    {
        $builder = new MessageBuilder();
        $builder->setFlags(1);
        $this->assertEquals(1, $builder->get()['flags']);
    }
}
