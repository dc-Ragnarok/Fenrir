<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers;

use Ragnarok\Fenrir\Rest\Helpers\GetNew;
use PHPUnit\Framework\TestCase;

class GetNewTest extends TestCase
{
    public function testGetNew(): void
    {
        $class = new class () {
            use GetNew;
        };

        $this->assertInstanceOf(
            $class::class,
            $class::new()
        );
    }
}
