<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Enums\EntitlementOwnerType;
use Ragnarok\Fenrir\Parts\Entitlement as EntitlementPart;
use Ragnarok\Fenrir\Rest\Helpers\Entitlement\GetEntitlementsBuilder;
use React\Promise\PromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/entitlement
 */
class Entitlement extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/entitlement#list-entitlements
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Entitlement[]>
     */
    public function listEntitlements(
        string $applicationId,
        ?GetEntitlementsBuilder $getEntitlementsBuilder = null
    ): PromiseInterface {
        $endpoint = Endpoint::bind(
            Endpoint::APPLICATION_ENTITLEMENTS,
            $applicationId
        );

        foreach ($getEntitlementsBuilder?->get() ?? [] as $key => $value) {
            $endpoint->addQuery($key, $value);
        }

        return $this->mapArrayPromise(
            $this->http->get($endpoint),
            EntitlementPart::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/entitlement#get-entitlement
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Entitlement>
     */
    public function getEntitlement(string $applicationId, string $entitlementId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::APPLICATION_ENTITLEMENT,
                    $applicationId,
                    $entitlementId
                )
            ),
            EntitlementPart::class
        );
    }

    /**
     * Marks a one-time purchase entitlement as used up. Only entitlements for
     * consumable SKUs can be consumed.
     *
     * @see https://discord.com/developers/docs/resources/entitlement#consume-an-entitlement
     *
     * @return PromiseInterface<void>
     */
    public function consumeEntitlement(string $applicationId, string $entitlementId): PromiseInterface
    {
        return $this->http->post(
            Endpoint::bind(
                Endpoint::APPLICATION_ENTITLEMENT_CONSUME,
                $applicationId,
                $entitlementId
            )
        );
    }

    /**
     * Grants an entitlement without charging, for testing an application's
     * premium paths. The returned entitlement has no starts_at or ends_at.
     *
     * @see https://discord.com/developers/docs/resources/entitlement#create-test-entitlement
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Entitlement>
     */
    public function createTestEntitlement(
        string $applicationId,
        string $skuId,
        string $ownerId,
        EntitlementOwnerType $ownerType
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::APPLICATION_ENTITLEMENTS,
                    $applicationId
                ),
                [
                    'sku_id' => $skuId,
                    'owner_id' => $ownerId,
                    'owner_type' => $ownerType->value,
                ]
            ),
            EntitlementPart::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/entitlement#delete-test-entitlement
     *
     * @return PromiseInterface<void>
     */
    public function deleteTestEntitlement(string $applicationId, string $entitlementId): PromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::APPLICATION_ENTITLEMENT,
                $applicationId,
                $entitlementId
            )
        );
    }
}
