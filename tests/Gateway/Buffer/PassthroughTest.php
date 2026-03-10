<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Gateway\Buffer;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Buffer\Passthrough;

class PassthroughTest extends TestCase
{
    public function testItPassesThroughEvents()
    {
        $passthrough = new Passthrough();

        $messages = [];
        $passthrough->onCompleteMessage(function (string $message) use (&$messages) {
            $messages[] = $message;
        });

        $passthrough->partialMessage('uno');
        $passthrough->partialMessage('dos');
        $passthrough->partialMessage('tres');
        $passthrough->partialMessage('quatro');
        $passthrough->partialMessage('I dont know how to spell cinqo');

        $this->assertEquals(['uno', 'dos', 'tres', 'quatro', 'I dont know how to spell cinqo'], $messages);
    }
}
