<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Entitlement;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Rest\Helpers\Entitlement\GetEntitlementsBuilder;

class GetEntitlementsBuilderTest extends TestCase
{
    /**
     * Discord takes sku_ids as one comma delimited value rather than a repeated
     * query parameter.
     */
    public function testItJoinsSkuIds(): void
    {
        $builder = GetEntitlementsBuilder::new()->setSkuIds(['::a::', '::b::']);

        $this->assertEquals('::a::,::b::', $builder->getSkuIds());
        $this->assertEquals(['sku_ids' => '::a::,::b::'], $builder->get());
    }

    public function testItBuildsEveryFilter(): void
    {
        $builder = GetEntitlementsBuilder::new()
            ->setUserId('::user::')
            ->setBefore('::before::')
            ->setAfter('::after::')
            ->setLimit(10)
            ->setGuildId('::guild::')
            ->setExcludeEnded(true)
            ->setExcludeDeleted(false);

        $this->assertEquals([
            'user_id' => '::user::',
            'before' => '::before::',
            'after' => '::after::',
            'limit' => 10,
            'guild_id' => '::guild::',
            'exclude_ended' => true,
            'exclude_deleted' => false,
        ], $builder->get());
    }

    public function testItStartsEmpty(): void
    {
        $this->assertEquals([], GetEntitlementsBuilder::new()->get());
    }
}
