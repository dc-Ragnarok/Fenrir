<?php

declare(strict_types=1);

namespace Exan\Fenrir;

use Exan\Fenrir\Rest\Helpers\GetNew;
use PHPUnit\Framework\TestCase;

class GetNewTest extends TestCase
{
    public function testGetNew()
    {
        $class = new class {
            use GetNew;
        };

        $this->assertTrue(
            $class::new() instanceof $class,
            'Class is not correct instance'
        );
    }
}
