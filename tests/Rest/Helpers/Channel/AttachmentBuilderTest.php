<?php

declare(strict_types=1);

namespace Tests\Exan\Dhp\Rest\Helpers\Channel;

use PHPUnit\Framework\TestCase;

use Exan\Dhp\Rest\Helpers\Channel\AttachmentBuilder;

class AttachmentBuilderTest extends TestCase
{
    public function testSetId()
    {
        $builder = new AttachmentBuilder();
        $builder->setId('::id::');
        $this->assertEquals('::id::', $builder->get()['id']);
    }

    public function testSetFilename()
    {
        $builder = new AttachmentBuilder();
        $builder->setFilename('::filename::');
        $this->assertEquals('::filename::', $builder->get()['filename']);
    }

    public function testSetDescription()
    {
        $builder = new AttachmentBuilder();
        $builder->setDescription('::description::');
        $this->assertEquals('::description::', $builder->get()['description']);
    }

    public function testSetContentType()
    {
        $builder = new AttachmentBuilder();
        $builder->setContentType('::content type::');
        $this->assertEquals('::content type::', $builder->get()['content_type']);
    }

    public function testSetSize()
    {
        $builder = new AttachmentBuilder();
        $builder->setSize(1024);
        $this->assertEquals(1024, $builder->get()['size']);
    }

    public function testSetUrl()
    {
        $builder = new AttachmentBuilder();
        $builder->setUrl('::url::');
        $this->assertEquals('::url::', $builder->get()['url']);
    }

    public function testSetProxyUrl()
    {
        $builder = new AttachmentBuilder();
        $builder->setProxyUrl('::proxy url::');
        $this->assertEquals('::proxy url::', $builder->get()['proxy_url']);
    }

    public function testSetHeight()
    {
        $builder = new AttachmentBuilder();
        $builder->setHeight(800);
        $this->assertEquals(800, $builder->get()['height']);
    }

    public function testSetWidth()
    {
        $builder = new AttachmentBuilder();
        $builder->setWidth(600);
        $this->assertEquals(600, $builder->get()['width']);
    }

    public function testSetEphemeral()
    {
        $builder = new AttachmentBuilder();
        $builder->setEphemeral(true);
        $this->assertEquals(true, $builder->get()['ephemeral']);
    }
}
