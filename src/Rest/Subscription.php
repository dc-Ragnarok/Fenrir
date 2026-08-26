<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\Subscription as SubscriptionPart;
use Ragnarok\Fenrir\Rest\Helpers\Subscription\GetSubscriptionsBuilder;
use React\Promise\PromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/subscription
 */
class Subscription extends HttpResource
{
    /**
     * discord-php/http declares both subscription endpoints with a leading
     * slash, unlike every other constant, and the request builder joins the
     * base url with a separator of its own. Trimming keeps the path from coming
     * out with a doubled slash, and stays correct if that is fixed upstream.
     */
    private static function path(string $endpoint): string
    {
        return ltrim($endpoint, '/');
    }

    /**
     * @see https://discord.com/developers/docs/resources/subscription#list-sku-subscriptions
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Subscription[]>
     */
    public function listSkuSubscriptions(
        string $skuId,
        ?GetSubscriptionsBuilder $getSubscriptionsBuilder = null
    ): PromiseInterface {
        $endpoint = Endpoint::bind(self::path(Endpoint::SKU_SUBSCRIPTIONS), $skuId);

        foreach ($getSubscriptionsBuilder?->get() ?? [] as $key => $value) {
            $endpoint->addQuery($key, $value);
        }

        return $this->mapArrayPromise(
            $this->http->get($endpoint),
            SubscriptionPart::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/subscription#get-sku-subscription
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Subscription>
     */
    public function getSkuSubscription(string $skuId, string $subscriptionId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(self::path(Endpoint::SKU_SUBSCRIPTION), $skuId, $subscriptionId)
            ),
            SubscriptionPart::class
        );
    }
}
