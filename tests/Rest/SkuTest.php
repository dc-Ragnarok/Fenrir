<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest;

use Ragnarok\Fenrir\Parts\Sku as SkuPart;
use Ragnarok\Fenrir\Rest\Sku;
use Tests\Ragnarok\Fenrir\Rest\HttpHelperTestCase;

class SkuTest extends HttpHelperTestCase
{
    protected string $httpItemClass = Sku::class;

    public static function httpBindingsProvider(): array
    {
        return [
            'List SKUs' => [
                'method' => 'listSkus',
                'args' => ['::application id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) []],
                ],
                'validationOptions' => [
                    'returnType' => SkuPart::class,
                    'array' => true,
                ],
            ],
        ];
    }
}
