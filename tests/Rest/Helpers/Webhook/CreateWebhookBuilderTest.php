<?php

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Webhook;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Enums\ImageData;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\CreateWebhookBuilder;

class CreateWebhookBuilderTest extends TestCase
{
    public function testItCanSetTheAvatar()
    {
        $builder = CreateWebhookBuilder::new();
        $builder->setAvatar('::image::', ImageData::PNG);

        $this->assertEquals('data:image/png;base64,OjppbWFnZTo6', $builder->getAvatar());
    }

    public function testItCanSetTheName()
    {
        $builder = CreateWebhookBuilder::new();
        $builder->setName('::name::');

        $this->assertEquals('::name::', $builder->getName());
    }
}
