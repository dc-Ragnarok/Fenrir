<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Command\Helpers;

use Discord\Http\Multipart\MultipartBody;
use PHPUnit\Framework\TestCase;
use Exan\Fenrir\Command\Helpers\InteractionCallbackBuilder;
use Exan\Fenrir\Enums\Command\InteractionCallbackTypes;

class InteractionCallbackBuilderTest extends TestCase
{
    public function testSetType()
    {
        $interactionCallbackBuilder = new InteractionCallbackBuilder();

        $interactionCallbackBuilder->setType(InteractionCallbackTypes::PONG);

        $this->assertEquals(InteractionCallbackTypes::PONG, $interactionCallbackBuilder->getType());
        $this->assertEquals(InteractionCallbackTypes::PONG->value, $interactionCallbackBuilder->get()['type']);
    }

    public function testGetMultipart()
    {
        $interactionCallbackBuilder = new InteractionCallbackBuilder();
        $interactionCallbackBuilder->setType(InteractionCallbackTypes::PONG);

        $interactionCallbackBuilder->addFile('file.png', '::spoopy binary::');

        $multipart = $interactionCallbackBuilder->get();

        $this->assertInstanceOf(MultipartBody::class, $multipart);
    }
}
