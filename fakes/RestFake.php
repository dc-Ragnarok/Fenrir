<?php

declare(strict_types=1);

namespace Fakes\Exan\Fenrir;

use Exan\Fenrir\Rest\Rest;
use Mockery;
use Mockery\Mock;
use ReflectionClass;

class RestFake
{
    public static function get(): Rest|Mock
    {
        $restMock = Mockery::mock(Rest::class);

        $reflectionClass = new ReflectionClass(Rest::class);

        foreach ($reflectionClass->getProperties() as $property) {
            if (!$property->isPublic()) {
                continue;
            }

            $restMock->{$property->getName()} = Mockery::mock($property->getType()->getName());
        }

        return $restMock;
    }
}
