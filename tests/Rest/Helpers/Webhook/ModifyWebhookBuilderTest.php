<?php

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Webhook;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Enums\ImageData;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\ModifyWebhookBuilder;

class ModifyWebhookBuilderTest extends TestCase
{
    public function testItCanSetTheAvatar()
    {
        $builder = ModifyWebhookBuilder::new();
        $builder->setAvatar('::image::', ImageData::PNG);

        $this->assertEquals('data:image/png;base64,OjppbWFnZTo6', $builder->getAvatar());
    }

    public function testItCanSetTheName()
    {
        $builder = ModifyWebhookBuilder::new();
        $builder->setName('::name::');

        $this->assertEquals('::name::', $builder->getName());
    }

    public function testItCanSetTheChannelId()
    {
        $builder = ModifyWebhookBuilder::new();
        $builder->setChannelId('::channel id::');

        $this->assertEquals('::channel id::', $builder->getChannelId());
    }
}
