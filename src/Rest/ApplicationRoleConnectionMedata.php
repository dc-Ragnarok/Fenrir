<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\Application as PartsApplication;
use Ragnarok\Fenrir\Parts\ApplicationRoleConnectionMetadata as PartsApplicationRoleConnectionMetadata;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/application-role-connection-metadata
 */
class ApplicationRoleConnectionMetadata extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/application-role-connection-metadata#get-application-role-connection-metadata-records
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationRoleConnectionMetadata>
     */
    public function getRecords(): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::APPLICATION_ROLE_CONNECTION_METADATA,
            ),
            PartsApplicationRoleConnectionMetadata::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/application-role-connection-metadata#update-application-role-connection-metadata-records
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\ApplicationRoleConnectionMetadata>
     */
    public function updateRecords(array $params): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->put(
                Endpoint::APPLICATION_ROLE_CONNECTION_METADATA,
                $params,
            ),
            PartsApplicationRoleConnectionMetadata::class,
        )->otherwise($this->logThrowable(...));
    }
}
