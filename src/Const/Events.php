<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Const;

class Events
{
    final public const RAW = 'RAW';
    final public const READY = 'READY';

    final public const APPLICATION_COMMAND_PERMISSIONS_UPDATE = 'APPLICATION_COMMAND_PERMISSIONS_UPDATE';
    final public const AUTO_MODERATION_RULE_CREATE = 'AUTO_MODERATION_RULE_CREATE';
    final public const AUTO_MODERATION_RULE_UPDATE = 'AUTO_MODERATION_RULE_UPDATE';
    final public const AUTO_MODERATION_RULE_DELETE = 'AUTO_MODERATION_RULE_DELETE';
    final public const AUTO_MODERATION_ACTION_EXECUTION = 'AUTO_MODERATION_ACTION_EXECUTION';

    final public const CHANNEL_CREATE = 'CHANNEL_CREATE';
    final public const CHANNEL_UPDATE = 'CHANNEL_UPDATE';
    final public const CHANNEL_DELETE = 'CHANNEL_DELETE';
    final public const CHANNEL_PINS_UPDATE = 'CHANNEL_PINS_UPDATE';

    final public const THREAD_CREATE = 'THREAD_CREATE';
    final public const THREAD_UPDATE = 'THREAD_UPDATE';
    final public const THREAD_DELETE = 'THREAD_DELETE';
    final public const THREAD_LIST_SYNC = 'THREAD_LIST_SYNC';
    final public const THREAD_MEMBER_UPDATE = 'THREAD_MEMBER_UPDATE';
    final public const THREAD_MEMBERS_UPDATE = 'THREAD_MEMBERS_UPDATE';

    final public const GUILD_CREATE = 'GUILD_CREATE';
    final public const GUILD_UPDATE = 'GUILD_UPDATE';
    final public const GUILD_DELETE = 'GUILD_DELETE';

    final public const GUILD_BAN_ADD = 'GUILD_BAN_ADD';
    final public const GUILD_BAN_REMOVE = 'GUILD_BAN_REMOVE';

    final public const GUILD_EMOJIS_UPDATE = 'GUILD_EMOJIS_UPDATE';
    final public const GUILD_STICKERS_UPDATE = 'GUILD_STICKERS_UPDATE';

    final public const GUILD_INTEGRATIONS_UPDATE = 'GUILD_INTEGRATIONS_UPDATE';

    final public const GUILD_MEMBER_ADD = 'GUILD_MEMBER_ADD';
    final public const GUILD_MEMBER_REMOVE = 'GUILD_MEMBER_REMOVE';
    final public const GUILD_MEMBER_UPDATE = 'GUILD_MEMBER_UPDATE';
    final public const GUILD_MEMBERS_CHUNK = 'GUILD_MEMBERS_CHUNK';

    final public const GUILD_ROLE_CREATE = 'GUILD_ROLE_CREATE';
    final public const GUILD_ROLE_UPDATE = 'GUILD_ROLE_UPDATE';
    final public const GUILD_ROLE_DELETE = 'GUILD_ROLE_DELETE';

    final public const GUILD_SCHEDULED_EVENT_CREATE = 'GUILD_SCHEDULED_EVENT_CREATE';
    final public const GUILD_SCHEDULED_EVENT_UPDATE = 'GUILD_SCHEDULED_EVENT_UPDATE';
    final public const GUILD_SCHEDULED_EVENT_DELETE = 'GUILD_SCHEDULED_EVENT_DELETE';
    final public const GUILD_SCHEDULED_EVENT_USER_ADD = 'GUILD_SCHEDULED_EVENT_USER_ADD';
    final public const GUILD_SCHEDULED_EVENT_USER_REMOVE = 'GUILD_SCHEDULED_EVENT_USER_REMOVE';

    final public const INTEGRATION_CREATE = 'INTEGRATION_CREATE';
    final public const INTEGRATION_UPDATE = 'INTEGRATION_UPDATE';
    final public const INTEGRATION_DELETE = 'INTEGRATION_DELETE';

    final public const INTERACTION_CREATE = 'INTERACTION_CREATE';

    final public const INVITE_CREATE = 'INVITE_CREATE';
    final public const INVITE_DELETE = 'INVITE_DELETE';

    final public const MESSAGE_CREATE = 'MESSAGE_CREATE';
    final public const MESSAGE_UPDATE = 'MESSAGE_UPDATE';
    final public const MESSAGE_DELETE = 'MESSAGE_DELETE';
    final public const MESSAGE_DELETE_BULK = 'MESSAGE_DELETE_BULK';
    final public const MESSAGE_REACTION_ADD = 'MESSAGE_REACTION_ADD';
    final public const MESSAGE_REACTION_REMOVE = 'MESSAGE_REACTION_REMOVE';
    final public const MESSAGE_REACTION_REMOVE_ALL = 'MESSAGE_REACTION_REMOVE_ALL';
    final public const MESSAGE_REACTION_REMOVE_EMOJI = 'MESSAGE_REACTION_REMOVE_EMOJI';

    final public const PRESENCE_UPDATE = 'PRESENCE_UPDATE';

    final public const STAGE_INSTANCE_CREATE = 'STAGE_INSTANCE_CREATE';
    final public const STAGE_INSTANCE_UPDATE = 'STAGE_INSTANCE_UPDATE';
    final public const STAGE_INSTANCE_DELETE = 'STAGE_INSTANCE_DELETE';

    final public const TYPING_START = 'TYPING_START';
    final public const USER_UPDATE = 'USER_UPDATE';

    final public const VOICE_STATE_UPDATE = 'VOICE_STATE_UPDATE';
    final public const VOICE_SERVER_UPDATE = 'VOICE_SERVER_UPDATE';

    final public const WEBHOOKS_UPDATE = 'WEBHOOKS_UPDATE';

    final public const MAPPINGS = [
        self::READY => \Ragnarok\Fenrir\Websocket\Events\Ready::class,

        self::APPLICATION_COMMAND_PERMISSIONS_UPDATE =>
            \Ragnarok\Fenrir\Websocket\Events\ApplicationCommandPermissionsUpdate::class,
        self::AUTO_MODERATION_RULE_CREATE => \Ragnarok\Fenrir\Websocket\Events\AutoModerationRuleCreate::class,
        self::AUTO_MODERATION_RULE_UPDATE => \Ragnarok\Fenrir\Websocket\Events\AutoModerationRuleUpdate::class,
        self::AUTO_MODERATION_RULE_DELETE => \Ragnarok\Fenrir\Websocket\Events\AutoModerationRuleDelete::class,
        self::AUTO_MODERATION_ACTION_EXECUTION =>
            \Ragnarok\Fenrir\Websocket\Events\AutoModerationActionExecution::class,

        self::CHANNEL_CREATE => \Ragnarok\Fenrir\Websocket\Events\ChannelCreate::class,
        self::CHANNEL_UPDATE => \Ragnarok\Fenrir\Websocket\Events\ChannelUpdate::class,
        self::CHANNEL_DELETE => \Ragnarok\Fenrir\Websocket\Events\ChannelDelete::class,
        self::CHANNEL_PINS_UPDATE => \Ragnarok\Fenrir\Websocket\Events\ChannelPinsUpdate::class,

        self::THREAD_CREATE => \Ragnarok\Fenrir\Websocket\Events\ThreadCreate::class,
        self::THREAD_UPDATE => \Ragnarok\Fenrir\Websocket\Events\ThreadUpdate::class,
        self::THREAD_DELETE => \Ragnarok\Fenrir\Websocket\Events\ThreadDelete::class,
        self::THREAD_LIST_SYNC => \Ragnarok\Fenrir\Websocket\Events\ThreadListSync::class,
        self::THREAD_MEMBER_UPDATE => \Ragnarok\Fenrir\Websocket\Events\ThreadMemberUpdate::class,
        self::THREAD_MEMBERS_UPDATE => \Ragnarok\Fenrir\Websocket\Events\ThreadMembersUpdate::class,

        self::GUILD_CREATE => \Ragnarok\Fenrir\Websocket\Events\GuildCreate::class,
        self::GUILD_UPDATE => \Ragnarok\Fenrir\Websocket\Events\GuildUpdate::class,
        self::GUILD_DELETE => \Ragnarok\Fenrir\Websocket\Events\GuildDelete::class,

        self::GUILD_BAN_ADD => \Ragnarok\Fenrir\Websocket\Events\GuildBanAdd::class,
        self::GUILD_BAN_REMOVE => \Ragnarok\Fenrir\Websocket\Events\GuildBanRemove::class,

        self::GUILD_EMOJIS_UPDATE => \Ragnarok\Fenrir\Websocket\Events\GuildEmojisUpdate::class,
        self::GUILD_STICKERS_UPDATE => \Ragnarok\Fenrir\Websocket\Events\GuildStickersUpdate::class,

        self::GUILD_INTEGRATIONS_UPDATE => \Ragnarok\Fenrir\Websocket\Events\GuildIntegrationsUpdate::class,

        self::GUILD_MEMBER_ADD => \Ragnarok\Fenrir\Websocket\Events\GuildMemberAdd::class,
        self::GUILD_MEMBER_REMOVE => \Ragnarok\Fenrir\Websocket\Events\GuildMemberRemove::class,
        self::GUILD_MEMBER_UPDATE => \Ragnarok\Fenrir\Websocket\Events\GuildMemberUpdate::class,
        self::GUILD_MEMBERS_CHUNK => \Ragnarok\Fenrir\Websocket\Events\GuildMembersChunk::class,

        self::GUILD_ROLE_CREATE => \Ragnarok\Fenrir\Websocket\Events\GuildRoleCreate::class,
        self::GUILD_ROLE_UPDATE => \Ragnarok\Fenrir\Websocket\Events\GuildRoleUpdate::class,
        self::GUILD_ROLE_DELETE => \Ragnarok\Fenrir\Websocket\Events\GuildRoleDelete::class,

        self::GUILD_SCHEDULED_EVENT_CREATE => \Ragnarok\Fenrir\Websocket\Events\GuildScheduledEventCreate::class,
        self::GUILD_SCHEDULED_EVENT_UPDATE => \Ragnarok\Fenrir\Websocket\Events\GuildScheduledEventUpdate::class,
        self::GUILD_SCHEDULED_EVENT_DELETE => \Ragnarok\Fenrir\Websocket\Events\GuildScheduledEventDelete::class,
        self::GUILD_SCHEDULED_EVENT_USER_ADD => \Ragnarok\Fenrir\Websocket\Events\GuildScheduledEventUserAdd::class,
        self::GUILD_SCHEDULED_EVENT_USER_REMOVE =>
            \Ragnarok\Fenrir\Websocket\Events\GuildScheduledEventUserRemove::class,

        self::INTEGRATION_CREATE => \Ragnarok\Fenrir\Websocket\Events\IntegrationCreate::class,
        self::INTEGRATION_UPDATE => \Ragnarok\Fenrir\Websocket\Events\IntegrationUpdate::class,
        self::INTEGRATION_DELETE => \Ragnarok\Fenrir\Websocket\Events\IntegrationDelete::class,
        self::INTERACTION_CREATE => \Ragnarok\Fenrir\Websocket\Events\InteractionCreate::class,

        self::INVITE_CREATE => \Ragnarok\Fenrir\Websocket\Events\InviteCreate::class,
        self::INVITE_DELETE => \Ragnarok\Fenrir\Websocket\Events\InviteDelete::class,

        self::MESSAGE_CREATE => \Ragnarok\Fenrir\Websocket\Events\MessageCreate::class,
        self::MESSAGE_UPDATE => \Ragnarok\Fenrir\Websocket\Events\MessageUpdate::class,
        self::MESSAGE_DELETE => \Ragnarok\Fenrir\Websocket\Events\MessageDelete::class,
        self::MESSAGE_DELETE_BULK => \Ragnarok\Fenrir\Websocket\Events\MessageDeleteBulk::class,
        self::MESSAGE_REACTION_ADD => \Ragnarok\Fenrir\Websocket\Events\MessageReactionAdd::class,
        self::MESSAGE_REACTION_REMOVE => \Ragnarok\Fenrir\Websocket\Events\MessageReactionRemove::class,
        self::MESSAGE_REACTION_REMOVE_ALL => \Ragnarok\Fenrir\Websocket\Events\MessageReactionRemoveAll::class,
        self::MESSAGE_REACTION_REMOVE_EMOJI => \Ragnarok\Fenrir\Websocket\Events\MessageReactionRemoveEmoji::class,

        self::PRESENCE_UPDATE => \Ragnarok\Fenrir\Websocket\Events\PresenceUpdate::class,

        self::STAGE_INSTANCE_CREATE => \Ragnarok\Fenrir\Websocket\Events\StageInstanceCreate::class,
        self::STAGE_INSTANCE_UPDATE => \Ragnarok\Fenrir\Websocket\Events\StageInstanceUpdate::class,
        self::STAGE_INSTANCE_DELETE => \Ragnarok\Fenrir\Websocket\Events\StageInstanceDelete::class,

        self::TYPING_START => \Ragnarok\Fenrir\Websocket\Events\TypingStart::class,
        self::USER_UPDATE => \Ragnarok\Fenrir\Websocket\Events\UserUpdate::class,

        self::VOICE_STATE_UPDATE => \Ragnarok\Fenrir\Websocket\Events\VoiceStateUpdate::class,
        self::VOICE_SERVER_UPDATE => \Ragnarok\Fenrir\Websocket\Events\VoiceServerUpdate::class,

        self::WEBHOOKS_UPDATE => \Ragnarok\Fenrir\Websocket\Events\WebhooksUpdate::class,
    ];
}
