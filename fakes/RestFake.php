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
        // $reflectionClass = new ReflectionClass(Rest::class);
        // $instance = ;
        // $reflectionProperty = $reflection->getProperty('changeMe');
        // $reflectionProperty->setValue($instance, 33);

        // var_dump($reflectionProperty->getValue($instance));
        // $restMock = Mockery::mock(Rest::class);

        // $instance = $reflectionClass->newInstanceWithoutConstructor();


        $reflection = new ReflectionClass(Rest::class);
        $instance = $reflection->newInstanceWithoutConstructor();
        // $reflectionProperty = $reflection->getProperty('changeMe');
        // $reflectionProperty->setValue($instance, 33);

        foreach ($reflection->getProperties() as $property) {
            if (!$property->isPublic()) {
                continue;
            }

            $property->setValue($instance, Mockery::mock($property->getType()->getName()));
        }

        return $instance;
    }
}
