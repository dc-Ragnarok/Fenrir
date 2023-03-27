<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use Carbon\Carbon;
use Ragnarok\Fenrir\Rest\Helpers\Channel\EmbedBuilder;
use PHPUnit\Framework\TestCase;

class EmbedBuilderTest extends TestCase
{
    public function testSetTitle()
    {
        $builder = new EmbedBuilder();
        $this->assertNull($builder->getTitle());
        $builder->setTitle('Test Title');

        $this->assertEquals('Test Title', $builder->get()['title']);
        $this->assertEquals('Test Title', $builder->getTitle());
    }

    public function testSetDescription()
    {
        $builder = new EmbedBuilder();
        $this->assertNull($builder->getDescription());
        $builder->setDescription('Test Description');

        $this->assertEquals('Test Description', $builder->get()['description']);
        $this->assertEquals('Test Description', $builder->getDescription());
    }

    public function testSetUrl()
    {
        $builder = new EmbedBuilder();
        $this->assertNull($builder->getUrl());
        $builder->setUrl('https://test.com');

        $this->assertEquals('https://test.com', $builder->get()['url']);
        $this->assertEquals('https://test.com', $builder->getUrl());
    }

    public function testSetTimestamp()
    {
        $builder = new EmbedBuilder();
        $this->assertNull($builder->getTimestamp());
        $timestamp = Carbon::now();
        $builder->setTimestamp($timestamp);

        $this->assertEquals($timestamp->toIso8601String(), $builder->get()['timestamp']);
        $this->assertEquals(new Carbon($timestamp->toIso8601String()), $builder->getTimestamp());
    }

    public function testSetColor()
    {
        $builder = new EmbedBuilder();
        $this->assertNull($builder->getColor());
        $builder->setColor(123456);

        $this->assertEquals(123456, $builder->get()['color']);
        $this->assertEquals(123456, $builder->getColor());
    }

    public function testSetColour()
    {
        $builder = new EmbedBuilder();
        $this->assertNull($builder->getColour());
        $builder->setColour(123456);

        $this->assertEquals(123456, $builder->get()['color']);
        $this->assertEquals(123456, $builder->getColour());
    }

    public function testSetFooter()
    {
        $builder = new EmbedBuilder();
        $this->assertNull($builder->getFooter());
        $builder->setFooter('Test Footer', 'https://test.com/icon.png', 'https://test.com/proxy_icon.png');

        $footer = $builder->get()['footer'];

        $this->assertEquals('Test Footer', $footer['text']);
        $this->assertEquals('https://test.com/icon.png', $footer['icon_url']);
        $this->assertEquals('https://test.com/proxy_icon.png', $footer['proxy_icon_url']);

        $this->assertEquals($footer, $builder->getFooter());
    }

    public function testSetImage()
    {
        $builder = new EmbedBuilder();
        $this->assertNull($builder->getImage());
        $builder->setImage('https://test.com/image.png', 'https://test.com/proxy_image.png', 100, 200);

        $image = $builder->get()['image'];

        $this->assertEquals('https://test.com/image.png', $image['url']);
        $this->assertEquals('https://test.com/proxy_image.png', $image['proxy_url']);
        $this->assertEquals(100, $image['height']);
        $this->assertEquals(200, $image['width']);
        $this->assertEquals($image, $builder->getImage());
    }

    public function testSetThumbnail()
    {
        $builder = new EmbedBuilder();
        $this->assertNull($builder->getThumbnail());
        $builder->setThumbnail('https://test.com/thumbnail.png', 'https://test.com/proxy_thumbnail.png', 100, 200);

        $thumbnail = $builder->get()['thumbnail'];

        $this->assertEquals('https://test.com/thumbnail.png', $thumbnail['url']);
        $this->assertEquals('https://test.com/proxy_thumbnail.png', $thumbnail['proxy_url']);
        $this->assertEquals(100, $thumbnail['height']);
        $this->assertEquals(200, $thumbnail['width']);
        $this->assertEquals($thumbnail, $builder->getThumbnail());
    }

    public function testSetAuthor()
    {
        $builder = new EmbedBuilder();
        $this->assertNull($builder->getAuthor());
        $builder->setAuthor(
            'Test Author',
            'https://test.com',
            'https://test.com/icon.png',
            'https://test-proxy.com/icon.png'
        );

        $author = $builder->get()['author'];

        $this->assertEquals('Test Author', $author['name']);
        $this->assertEquals('https://test.com', $author['url']);
        $this->assertEquals('https://test.com/icon.png', $author['icon_url']);
        $this->assertEquals('https://test-proxy.com/icon.png', $author['proxy_icon_url']);
        $this->assertEquals($author, $builder->getAuthor());
    }

    public function testAddField()
    {
        $builder = new EmbedBuilder();
        $this->assertNull($builder->getFields());
        $builder->addField('Test Field 1', 'Test Value 1', true);
        $builder->addField('Test Field 2', 'Test Value 2', false);

        $fields = $builder->get()['fields'];

        $this->assertEquals('Test Field 1', $fields[0]['name']);
        $this->assertEquals('Test Value 1', $fields[0]['value']);
        $this->assertTrue($fields[0]['inline']);
        $this->assertEquals('Test Field 2', $fields[1]['name']);
        $this->assertEquals('Test Value 2', $fields[1]['value']);
        $this->assertFalse($fields[1]['inline']);
        $this->assertEquals($fields, $builder->getFields());
    }

    public function testSetVideo()
    {
        $builder = new EmbedBuilder();
        $this->assertNull($builder->getVideo());
        $builder->setVideo('https://test.com/video.mp4', 'https://test-proxy.com/video.mp4', 100, 200);

        $video = $builder->get()['video'];

        $this->assertEquals('https://test.com/video.mp4', $video['url']);
        $this->assertEquals('https://test-proxy.com/video.mp4', $video['proxy_url']);
        $this->assertEquals(100, $video['height']);
        $this->assertEquals(200, $video['width']);
        $this->assertEquals($video, $builder->getVideo());
    }

    public function testSetProvider()
    {
        $builder = new EmbedBuilder();
        $this->assertNull($builder->getProvider());
        $builder->setProvider('Test Provider', 'https://test.com');

        $provider = $builder->get()['provider'];

        $this->assertEquals('Test Provider', $provider['name']);
        $this->assertEquals('https://test.com', $provider['url']);
        $this->assertEquals($provider, $builder->getProvider());
    }
}
