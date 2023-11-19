<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\Application as PartsApplication;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/application
 */
class Application extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/application#get-current-application
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Application>
     */
    public function getCurrent(): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                'applications/@me' // @todo update endpoint to Endpoint:: when available
            ),
            PartsApplication::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/application#edit-current-application
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Application>
     */
    public function editCurrent(array $params): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->patch(
                'applications/@me', // @todo update endpoint to Endpoint:: when available
                $params,
            ),
            PartsApplication::class,
        )->otherwise($this->logThrowable(...));
    }
}
