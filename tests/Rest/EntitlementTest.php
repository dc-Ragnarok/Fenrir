<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest;

use Ragnarok\Fenrir\Enums\EntitlementOwnerType;
use Ragnarok\Fenrir\Parts\Entitlement as EntitlementPart;
use Ragnarok\Fenrir\Rest\Entitlement;
use Ragnarok\Fenrir\Rest\Helpers\Entitlement\GetEntitlementsBuilder;
use Tests\Ragnarok\Fenrir\Rest\HttpHelperTestCase;

class EntitlementTest extends HttpHelperTestCase
{
    protected string $httpItemClass = Entitlement::class;

    public static function httpBindingsProvider(): array
    {
        return [
            'List entitlements' => [
                'method' => 'listEntitlements',
                'args' => ['::application id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) []],
                ],
                'validationOptions' => [
                    'returnType' => EntitlementPart::class,
                    'array' => true,
                ],
            ],
            'List entitlements with filters' => [
                'method' => 'listEntitlements',
                'args' => [
                    '::application id::',
                    GetEntitlementsBuilder::new()
                        ->setUserId('::user id::')
                        ->setSkuIds(['::sku a::', '::sku b::'])
                        ->setExcludeEnded(true)
                        ->setLimit(50),
                ],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) []],
                ],
                'validationOptions' => [
                    'returnType' => EntitlementPart::class,
                    'array' => true,
                ],
            ],
            'Get entitlement' => [
                'method' => 'getEntitlement',
                'args' => ['::application id::', '::entitlement id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => EntitlementPart::class,
                ],
            ],
            'Consume entitlement' => [
                'method' => 'consumeEntitlement',
                'args' => ['::application id::', '::entitlement id::'],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            'Create test entitlement' => [
                'method' => 'createTestEntitlement',
                'args' => [
                    '::application id::',
                    '::sku id::',
                    '::guild id::',
                    EntitlementOwnerType::GUILD_SUBSCRIPTION,
                ],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => EntitlementPart::class,
                ],
            ],
            'Delete test entitlement' => [
                'method' => 'deleteTestEntitlement',
                'args' => ['::application id::', '::entitlement id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
        ];
    }
}
