<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Exan\Fenrir\DataMapper;
use Exan\Fenrir\Parts\User as UserPart;
use Exan\Fenrir\Rest\Helpers\HttpHelper;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/user
 */
class User
{
    use HttpHelper;

    public function __construct(private Http $http, private DataMapper $jsonMapper)
    {
    }

    public function getCurrentUser(): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(Endpoint::USER_CURRENT)
            ),
            UserPart::class
        );
    }
}
