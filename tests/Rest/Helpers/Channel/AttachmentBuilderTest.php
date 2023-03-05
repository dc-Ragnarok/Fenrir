<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\Channel;

use PHPUnit\Framework\TestCase;
use Exan\Fenrir\Rest\Helpers\Channel\AttachmentBuilder;

class AttachmentBuilderTest extends TestCase
{
    public function testSetId()
    {
        $builder = new AttachmentBuilder();
        $this->assertNull($builder->getId());
        $builder->setId('::id::');
        $this->assertEquals('::id::', $builder->get()['id']);
        $this->assertEquals('::id::', $builder->getId());
    }

    public function testSetFilename()
    {
        $builder = new AttachmentBuilder();
        $this->assertNull($builder->getFilename());

        $builder->setFilename('::filename::');
        $this->assertEquals('::filename::', $builder->get()['filename']);
        $this->assertEquals('::filename::', $builder->getFilename());
    }

    public function testSetDescription()
    {
        $builder = new AttachmentBuilder();
        $this->assertNull($builder->getDescription());
        $builder->setDescription('::description::');
        $this->assertEquals('::description::', $builder->get()['description']);
        $this->assertEquals('::description::', $builder->getDescription());
    }

    public function testSetContentType()
    {
        $builder = new AttachmentBuilder();
        $this->assertNull($builder->getContentType());
        $builder->setContentType('::content type::');
        $this->assertEquals('::content type::', $builder->get()['content_type']);
        $this->assertEquals('::content type::', $builder->getContentType());
    }

    public function testSetSize()
    {
        $builder = new AttachmentBuilder();
        $this->assertNull($builder->getSize());
        $builder->setSize(1024);
        $this->assertEquals(1024, $builder->get()['size']);
        $this->assertEquals(1024, $builder->getSize());
    }

    public function testSetUrl()
    {
        $builder = new AttachmentBuilder();
        $this->assertNull($builder->getUrl());
        $builder->setUrl('::url::');
        $this->assertEquals('::url::', $builder->get()['url']);
        $this->assertEquals('::url::', $builder->getUrl());
    }

    public function testSetProxyUrl()
    {
        $builder = new AttachmentBuilder();
        $this->assertNull($builder->getProxyUrl());
        $builder->setProxyUrl('::proxy url::');
        $this->assertEquals('::proxy url::', $builder->getProxyUrl());
    }

    public function testSetHeight()
    {
        $builder = new AttachmentBuilder();
        $this->assertNull($builder->getHeight());
        $builder->setHeight(800);
        $this->assertEquals(800, $builder->get()['height']);
        $this->assertEquals(800, $builder->getHeight());
    }

    public function testSetWidth()
    {
        $builder = new AttachmentBuilder();
        $this->assertNull($builder->getWidth());
        $builder->setWidth(600);
        $this->assertEquals(600, $builder->get()['width']);
        $this->assertEquals(600, $builder->getWidth());
    }

    public function testSetEphemeral()
    {
        $builder = new AttachmentBuilder();
        $this->assertNull($builder->getWidth());
        $builder->setEphemeral(true);
        $this->assertEquals(true, $builder->get()['ephemeral']);
        $this->assertEquals(true, $builder->getEphemeral());
    }
}
