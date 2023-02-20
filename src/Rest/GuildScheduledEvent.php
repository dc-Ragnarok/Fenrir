<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest;

use Discord\Http\Http;
use Exan\Fenrir\Rest\Helpers\HttpHelper;
use JsonMapper;

/**
 * @see https://discord.com/developers/docs/resources/guild-scheduled-event
 */
class GuildScheduledEvent
{
    use HttpHelper;

    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-scheduled-event#list-scheduled-events-for-guild
     * @todo implement call
     */
    public function list()
    {

    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-scheduled-event#get-guild-scheduled-event
     * @todo implement call
     */
    public function get()
    {

    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-scheduled-event#create-guild-scheduled-event
     * @todo implement call
     */
    public function create()
    {

    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-scheduled-event#modify-guild-scheduled-event
     * @todo implement call
     */
    public function modify()
    {

    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-scheduled-event#delete-guild-scheduled-event
     * @todo implement call
     */
    public function delete()
    {

    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-scheduled-event#get-guild-scheduled-event-users
     * @todo implement call
     */
    public function getUsers()
    {

    }
}
