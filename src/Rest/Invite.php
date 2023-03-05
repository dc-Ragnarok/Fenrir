<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Ragnarok\Fenrir\Parts\Invite as PartsInvite;
use Ragnarok\Fenrir\Rest\Helpers\HttpHelper;
use JsonMapper;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/invite
 */
class Invite
{
    use HttpHelper;

    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/invite#get-invite
     *
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Invite>
     */
    public function get(string $code)
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::INVITE,
                    $code
                )
            ),
            PartsInvite::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/invite#delete-invite
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function delete(string $code)
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::INVITE,
                $code
            )
        );
    }
}
