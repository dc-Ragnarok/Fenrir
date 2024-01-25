<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Parts\AutoModerationRuleObject;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/auto-moderation
 */
class GuildAutoModeration extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/auto-moderation#list-auto-moderation-rules-for-guild
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\AutoModerationRuleObject[]>
     */
    public function list(string $guildId): ExtendedPromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(Endpoint::bind(Endpoint::GUILD_AUTO_MODERATION_RULES, $guildId)),
            AutoModerationRuleObject::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/auto-moderation#get-auto-moderation-rule
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\AutoModerationRuleObject>
     */
    public function get(string $guildId, string $autoModerationRuleId): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_AUTO_MODERATION_RULE,
                    $guildId,
                    $autoModerationRuleId
                )
            ),
            AutoModerationRuleObject::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/auto-moderation#create-auto-moderation-rule
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\AutoModerationRuleObject>
     */
    public function create(string $guildId, array $params, ?string $reason): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::GUILD_AUTO_MODERATION_RULES,
                    $guildId,
                ),
                $params,
                $this->getAuditLogReasonHeader($reason)
            ),
            AutoModerationRuleObject::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/auto-moderation#modify-auto-moderation-rule
     * @return ExtendedPromiseInterface<\Ragnarok\Fenrir\Parts\AutoModerationRuleObject>
     */
    public function modify(string $guildId, string $autoModerationRuleId, array $params, ?string $reason): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::GUILD_AUTO_MODERATION_RULE,
                    $guildId,
                    $autoModerationRuleId
                ),
                $params,
                $this->getAuditLogReasonHeader($reason)
            ),
            AutoModerationRuleObject::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/auto-moderation#delete-auto-moderation-rule
     * @return ExtendedPromiseInterface<void>
     */
    public function delete(string $guildId, string $autoModerationRuleId, ?string $reason): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->delete(
                Endpoint::bind(
                    Endpoint::GUILD_AUTO_MODERATION_RULE,
                    $guildId,
                    $autoModerationRuleId
                ),
                headers: $this->getAuditLogReasonHeader($reason)
            ),
            AutoModerationRuleObject::class,
        );
    }
}
