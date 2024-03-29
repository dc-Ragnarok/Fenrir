<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\Invite as PartsInvite;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/invite
 */
class Invite extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/invite#get-invite
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Invite>
     */
    public function get(string $code): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::INVITE,
                    $code
                )
            ),
            PartsInvite::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/invite#delete-invite
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function delete(string $code): ExtendedPromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::INVITE,
                $code
            )
        )->otherwise($this->logThrowable(...));
    }
}
