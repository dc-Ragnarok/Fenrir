<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\Guild;
use Ragnarok\Fenrir\Parts\GuildTemplate as PartsGuildTemplate;
use Ragnarok\Fenrir\Rest\Helpers\HttpHelper;
use React\Promise\PromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/guild-template
 */
class GuildTemplate extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/guild-template#get-guild-templates
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildTemplate>
     */
    public function list(string $guildId): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(Endpoint::bind(Endpoint::GUILD_TEMPLATES, $guildId)),
            PartsGuildTemplate::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-template#get-guild-template
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildTemplate>
     */
    public function get(string $code): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(Endpoint::bind(Endpoint::GUILDS_TEMPLATE, $code)),
            PartsGuildTemplate::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-template#create-guild-template
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildTemplate>
     */
    public function create(string $guildId, array $params): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(Endpoint::bind(Endpoint::GUILD_TEMPLATES, $guildId), $params),
            PartsGuildTemplate::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-template#modify-guild-template
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildTemplate>
     */
    public function modify(string $guildId, string $code, array $params): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->patch(Endpoint::bind(Endpoint::GUILD_TEMPLATE, $guildId, $code), $params),
            PartsGuildTemplate::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-template#delete-guild-template
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildTemplate>
     */
    public function delete(string $guildId, string $code): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->delete(Endpoint::bind(Endpoint::GUILD_TEMPLATE, $guildId, $code)),
            PartsGuildTemplate::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-template#create-guild-from-guild-template
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Guild>
     */
    public function createGuildFromTemplate(string $code, array $params): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(Endpoint::bind(Endpoint::GUILD_TEMPLATE, $code), $params),
            Guild::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/guild-template#sync-guild-template
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\GuildTemplate>
     */
    public function sync(string $guildId, string $code): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->put(Endpoint::bind(Endpoint::GUILD_TEMPLATE, $guildId, $code)),
            PartsGuildTemplate::class,
        );
    }
}
