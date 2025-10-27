<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\ApplicationRoleConnectionMetadata as PartsApplicationRoleConnectionMetadata;
use React\Promise\PromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/application-role-connection-metadata
 */
class ApplicationRoleConnectionMetadata extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/application-role-connection-metadata#get-application-role-connection-metadata-records
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationRoleConnectionMetadata>
     */
    public function getRecords(string $applicationId): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::APPLICATION_ROLE_CONNECTION_METADATA,
                    $applicationId
                )
            ),
            PartsApplicationRoleConnectionMetadata::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/application-role-connection-metadata#update-application-role-connection-metadata-records
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationRoleConnectionMetadata>
     */
    public function updateRecords(string $applicationId, array $params): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->put(
                Endpoint::bind(
                    Endpoint::APPLICATION_ROLE_CONNECTION_METADATA,
                    $applicationId
                ),
                $params,
            ),
            PartsApplicationRoleConnectionMetadata::class,
        );
    }
}
