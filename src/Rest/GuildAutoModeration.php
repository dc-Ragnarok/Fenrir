<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Http;
use Ragnarok\Fenrir\Rest\Helpers\HttpHelper;
use JsonMapper;

/**
 * @see https://discord.com/developers/docs/resources/auto-moderation
 */
class GuildAutoModeration
{
    use HttpHelper;

    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/auto-moderation#list-auto-moderation-rules-for-guild
     * @todo implement call
     */
    public function list()
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/auto-moderation#get-auto-moderation-rule
     * @todo implement call
     */
    public function get()
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/auto-moderation#create-auto-moderation-rule
     * @todo implement call
     */
    public function create()
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/auto-moderation#modify-auto-moderation-rule
     * @todo implement call
     */
    public function modify()
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/auto-moderation#delete-auto-moderation-rule
     * @todo implement call
     */
    public function delete()
    {
    }
}
