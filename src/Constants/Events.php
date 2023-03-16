<?php

declare(strict_types=1);

namespace Exan\Fenrir\Constants;

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
        self::READY => \Exan\Fenrir\Websocket\Events\Ready::class,

        self::APPLICATION_COMMAND_PERMISSIONS_UPDATE =>
            \Exan\Fenrir\Websocket\Events\ApplicationCommandPermissionsUpdate::class,
        self::AUTO_MODERATION_RULE_CREATE => \Exan\Fenrir\Websocket\Events\AutoModerationRuleCreate::class,
        self::AUTO_MODERATION_RULE_UPDATE => \Exan\Fenrir\Websocket\Events\AutoModerationRuleUpdate::class,
        self::AUTO_MODERATION_RULE_DELETE => \Exan\Fenrir\Websocket\Events\AutoModerationRuleDelete::class,
        self::AUTO_MODERATION_ACTION_EXECUTION =>
            \Exan\Fenrir\Websocket\Events\AutoModerationActionExecution::class,

        self::CHANNEL_CREATE => \Exan\Fenrir\Websocket\Events\ChannelCreate::class,
        self::CHANNEL_UPDATE => \Exan\Fenrir\Websocket\Events\ChannelUpdate::class,
        self::CHANNEL_DELETE => \Exan\Fenrir\Websocket\Events\ChannelDelete::class,
        self::CHANNEL_PINS_UPDATE => \Exan\Fenrir\Websocket\Events\ChannelPinsUpdate::class,

        self::THREAD_CREATE => \Exan\Fenrir\Websocket\Events\ThreadCreate::class,
        self::THREAD_UPDATE => \Exan\Fenrir\Websocket\Events\ThreadUpdate::class,
        self::THREAD_DELETE => \Exan\Fenrir\Websocket\Events\ThreadDelete::class,
        self::THREAD_LIST_SYNC => \Exan\Fenrir\Websocket\Events\ThreadListSync::class,
        self::THREAD_MEMBER_UPDATE => \Exan\Fenrir\Websocket\Events\ThreadMemberUpdate::class,
        self::THREAD_MEMBERS_UPDATE => \Exan\Fenrir\Websocket\Events\ThreadMembersUpdate::class,

        self::GUILD_CREATE => \Exan\Fenrir\Websocket\Events\GuildCreate::class,
        self::GUILD_UPDATE => \Exan\Fenrir\Websocket\Events\GuildUpdate::class,
        self::GUILD_DELETE => \Exan\Fenrir\Websocket\Events\GuildDelete::class,

        self::GUILD_BAN_ADD => \Exan\Fenrir\Websocket\Events\GuildBanAdd::class,
        self::GUILD_BAN_REMOVE => \Exan\Fenrir\Websocket\Events\GuildBanRemove::class,

        self::GUILD_EMOJIS_UPDATE => \Exan\Fenrir\Websocket\Events\GuildEmojisUpdate::class,
        self::GUILD_STICKERS_UPDATE => \Exan\Fenrir\Websocket\Events\GuildStickersUpdate::class,

        self::GUILD_INTEGRATIONS_UPDATE => \Exan\Fenrir\Websocket\Events\GuildIntegrationsUpdate::class,

        self::GUILD_MEMBER_ADD => \Exan\Fenrir\Websocket\Events\GuildMemberAdd::class,
        self::GUILD_MEMBER_REMOVE => \Exan\Fenrir\Websocket\Events\GuildMemberRemove::class,
        self::GUILD_MEMBER_UPDATE => \Exan\Fenrir\Websocket\Events\GuildMemberUpdate::class,
        self::GUILD_MEMBERS_CHUNK => \Exan\Fenrir\Websocket\Events\GuildMembersChunk::class,

        self::GUILD_ROLE_CREATE => \Exan\Fenrir\Websocket\Events\GuildRoleCreate::class,
        self::GUILD_ROLE_UPDATE => \Exan\Fenrir\Websocket\Events\GuildRoleUpdate::class,
        self::GUILD_ROLE_DELETE => \Exan\Fenrir\Websocket\Events\GuildRoleDelete::class,

        self::GUILD_SCHEDULED_EVENT_CREATE => \Exan\Fenrir\Websocket\Events\GuildScheduledEventCreate::class,
        self::GUILD_SCHEDULED_EVENT_UPDATE => \Exan\Fenrir\Websocket\Events\GuildScheduledEventUpdate::class,
        self::GUILD_SCHEDULED_EVENT_DELETE => \Exan\Fenrir\Websocket\Events\GuildScheduledEventDelete::class,
        self::GUILD_SCHEDULED_EVENT_USER_ADD => \Exan\Fenrir\Websocket\Events\GuildScheduledEventUserAdd::class,
        self::GUILD_SCHEDULED_EVENT_USER_REMOVE =>
            \Exan\Fenrir\Websocket\Events\GuildScheduledEventUserRemove::class,

        self::INTEGRATION_CREATE => \Exan\Fenrir\Websocket\Events\IntegrationCreate::class,
        self::INTEGRATION_UPDATE => \Exan\Fenrir\Websocket\Events\IntegrationUpdate::class,
        self::INTEGRATION_DELETE => \Exan\Fenrir\Websocket\Events\IntegrationDelete::class,
        self::INTERACTION_CREATE => \Exan\Fenrir\Websocket\Events\InteractionCreate::class,

        self::INVITE_CREATE => \Exan\Fenrir\Websocket\Events\InviteCreate::class,
        self::INVITE_DELETE => \Exan\Fenrir\Websocket\Events\InviteDelete::class,

        self::MESSAGE_CREATE => \Exan\Fenrir\Websocket\Events\MessageCreate::class,
        self::MESSAGE_UPDATE => \Exan\Fenrir\Websocket\Events\MessageUpdate::class,
        self::MESSAGE_DELETE => \Exan\Fenrir\Websocket\Events\MessageDelete::class,
        self::MESSAGE_DELETE_BULK => \Exan\Fenrir\Websocket\Events\MessageDeleteBulk::class,
        self::MESSAGE_REACTION_ADD => \Exan\Fenrir\Websocket\Events\MessageReactionAdd::class,
        self::MESSAGE_REACTION_REMOVE => \Exan\Fenrir\Websocket\Events\MessageReactionRemove::class,
        self::MESSAGE_REACTION_REMOVE_ALL => \Exan\Fenrir\Websocket\Events\MessageReactionRemoveAll::class,
        self::MESSAGE_REACTION_REMOVE_EMOJI => \Exan\Fenrir\Websocket\Events\MessageReactionRemoveEmoji::class,

        self::PRESENCE_UPDATE => \Exan\Fenrir\Websocket\Events\PresenceUpdate::class,

        self::STAGE_INSTANCE_CREATE => \Exan\Fenrir\Websocket\Events\StageInstanceCreate::class,
        self::STAGE_INSTANCE_UPDATE => \Exan\Fenrir\Websocket\Events\StageInstanceUpdate::class,
        self::STAGE_INSTANCE_DELETE => \Exan\Fenrir\Websocket\Events\StageInstanceDelete::class,

        self::TYPING_START => \Exan\Fenrir\Websocket\Events\TypingStart::class,
        self::USER_UPDATE => \Exan\Fenrir\Websocket\Events\UserUpdate::class,

        self::VOICE_STATE_UPDATE => \Exan\Fenrir\Websocket\Events\VoiceStateUpdate::class,
        self::VOICE_SERVER_UPDATE => \Exan\Fenrir\Websocket\Events\VoiceServerUpdate::class,

        self::WEBHOOKS_UPDATE => \Exan\Fenrir\Websocket\Events\WebhooksUpdate::class,
    ];
}
