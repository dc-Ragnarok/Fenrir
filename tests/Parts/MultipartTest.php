<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Parts;

use Exan\Fenrir\Parts\Multipart;
use Exan\Fenrir\Parts\MultipartField;
use Mockery;
use PHPUnit\Framework\TestCase;

class MultipartTest extends TestCase
{
    public function testFormBuilding()
    {
        $fields = array_map(function (string $return) {
            $mock = Mockery::mock(MultipartField::class);
            $mock->shouldReceive('__toString')->andReturn($return);

            return $mock;
        }, ['::first field::', '::second field::', '::third field::']);

        $multipart = new Multipart($fields, '::boundary::');

        $this->assertEquals(
            <<<EXPECTED
            --::boundary::
            ::first field::
            --::boundary::
            ::second field::
            --::boundary::
            ::third field::
            --::boundary::--
            EXPECTED,
            $multipart->getBody()
        );

        $this->assertEquals([
            'Content-Type' => 'multipart/form-data; boundary=::boundary::',
            'Content-Length' => strlen($multipart->getBody()),
        ], $multipart->getHeaders());
    }
}
