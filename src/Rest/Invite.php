<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest;

use Discord\Http\Http;
use Exan\Fenrir\Rest\Helpers\HttpHelper;
use JsonMapper;

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
     * @todo implement call
     */
    public function get()
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/invite#delete-invite
     * @todo implement call
     */
    public function delete()
    {
    }
}
