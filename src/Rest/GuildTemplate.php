<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\Guild;
use Ragnarok\Fenrir\Parts\GuildTemplate as PartsGuildTemplate;
use Ragnarok\Fenrir\Rest\Helpers\HttpHelper;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/guild-template
 */
class GuildTemplate extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/guild-template#get-guild-templates
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildTemplate>
     */
    public function list(string $guildId): ExtendedPromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(Endpoint::bind(Endpoint::GUILD_TEMPLATES, $guildId)),
            PartsGuildTemplate::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-template#get-guild-template
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildTemplate>
     */
    public function get(string $code): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(Endpoint::bind(Endpoint::GUILDS_TEMPLATE, $code)),
            PartsGuildTemplate::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-template#create-guild-template
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildTemplate>
     */
    public function create(string $guildId, array $params): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(Endpoint::bind(Endpoint::GUILD_TEMPLATES, $guildId), $params),
            PartsGuildTemplate::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-template#modify-guild-template
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildTemplate>
     */
    public function modify(string $guildId, string $code, array $params): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->patch(Endpoint::bind(Endpoint::GUILD_TEMPLATE, $guildId, $code), $params),
            PartsGuildTemplate::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-template#delete-guild-template
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildTemplate>
     */
    public function delete(string $guildId, string $code): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->delete(Endpoint::bind(Endpoint::GUILD_TEMPLATE, $guildId, $code)),
            PartsGuildTemplate::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-template#create-guild-from-guild-template
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\Guild>
     */
    public function createGuildFromTemplate(string $code, array $params): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(Endpoint::bind(Endpoint::GUILD_TEMPLATE, $code), $params),
            Guild::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-template#sync-guild-template
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\GuildTemplate>
     */
    public function sync(string $guildId, string $code): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->put(Endpoint::bind(Endpoint::GUILD_TEMPLATE, $guildId, $code)),
            PartsGuildTemplate::class,
        );
    }
}
