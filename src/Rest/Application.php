<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Ragnarok\Fenrir\Parts\Application as PartsApplication;
use React\Promise\PromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/application
 */
class Application extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/application#get-current-application
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Application>
     */
    public function getCurrent(): PromiseInterface
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
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Application>
     */
    public function editCurrent(array $params): PromiseInterface
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
