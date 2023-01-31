<?php

declare(strict_types=1);

namespace Exan\Dhp\Const;

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
        self::APPLICATION_COMMAND_PERMISSIONS_UPDATE =>
            \Exan\Dhp\Websocket\Events\ApplicationCommandPermissionsUpdate::class,
        self::AUTO_MODERATION_RULE_CREATE => \Exan\Dhp\Websocket\Events\AutoModerationRuleCreate::class,
        self::AUTO_MODERATION_RULE_UPDATE => \Exan\Dhp\Websocket\Events\AutoModerationRuleUpdate::class,
        self::AUTO_MODERATION_RULE_DELETE => \Exan\Dhp\Websocket\Events\AutoModerationRuleDelete::class,
        self::AUTO_MODERATION_ACTION_EXECUTION => \Exan\Dhp\Websocket\Events\AutoModerationActionExecution::class,

        self::CHANNEL_CREATE => \Exan\Dhp\Websocket\Events\ChannelCreate::class,
        self::CHANNEL_UPDATE => \Exan\Dhp\Websocket\Events\ChannelUpdate::class,
        self::CHANNEL_DELETE => \Exan\Dhp\Websocket\Events\ChannelDelete::class,
        self::CHANNEL_PINS_UPDATE => \Exan\Dhp\Websocket\Events\ChannelPinsUpdate::class,

        self::THREAD_CREATE => \Exan\Dhp\Websocket\Events\ThreadCreate::class,
        self::THREAD_UPDATE => \Exan\Dhp\Websocket\Events\ThreadUpdate::class,
        self::THREAD_DELETE => \Exan\Dhp\Websocket\Events\ThreadDelete::class,
        self::THREAD_LIST_SYNC => \Exan\Dhp\Websocket\Events\ThreadListSync::class,
        self::THREAD_MEMBER_UPDATE => \Exan\Dhp\Websocket\Events\ThreadMemberUpdate::class,
        self::THREAD_MEMBERS_UPDATE => \Exan\Dhp\Websocket\Events\ThreadMembersUpdate::class,

        self::GUILD_CREATE => \Exan\Dhp\Websocket\Events\GuildCreate::class,
        self::GUILD_UPDATE => \Exan\Dhp\Websocket\Events\GuildUpdate::class,
        self::GUILD_DELETE => \Exan\Dhp\Websocket\Events\GuildDelete::class,

        self::GUILD_BAN_ADD => \Exan\Dhp\Websocket\Events\GuildBanAdd::class,
        self::GUILD_BAN_REMOVE => \Exan\Dhp\Websocket\Events\GuildBanRemove::class,

        self::GUILD_EMOJIS_UPDATE => \Exan\Dhp\Websocket\Events\GuildEmojisUpdate::class,
        self::GUILD_STICKERS_UPDATE => \Exan\Dhp\Websocket\Events\GuildStickersUpdate::class,

        self::GUILD_INTEGRATIONS_UPDATE => \Exan\Dhp\Websocket\Events\GuildIntegrationsUpdate::class,

        self::GUILD_MEMBER_ADD => \Exan\Dhp\Websocket\Events\GuildMemberAdd::class,
        self::GUILD_MEMBER_REMOVE => \Exan\Dhp\Websocket\Events\GuildMemberRemove::class,
        self::GUILD_MEMBER_UPDATE => \Exan\Dhp\Websocket\Events\GuildMemberUpdate::class,
        self::GUILD_MEMBERS_CHUNK => \Exan\Dhp\Websocket\Events\GuildMembersChunk::class,

        self::GUILD_ROLE_CREATE => \Exan\Dhp\Websocket\Events\GuildRoleCreate::class,
        self::GUILD_ROLE_UPDATE => \Exan\Dhp\Websocket\Events\GuildRoleUpdate::class,
        self::GUILD_ROLE_DELETE => \Exan\Dhp\Websocket\Events\GuildRoleDelete::class,

        self::GUILD_SCHEDULED_EVENT_CREATE => \Exan\Dhp\Websocket\Events\GuildScheduledEventCreate::class,
        self::GUILD_SCHEDULED_EVENT_UPDATE => \Exan\Dhp\Websocket\Events\GuildScheduledEventUpdate::class,
        self::GUILD_SCHEDULED_EVENT_DELETE => \Exan\Dhp\Websocket\Events\GuildScheduledEventDelete::class,
        self::GUILD_SCHEDULED_EVENT_USER_ADD => \Exan\Dhp\Websocket\Events\GuildScheduledEventUserAdd::class,
        self::GUILD_SCHEDULED_EVENT_USER_REMOVE => \Exan\Dhp\Websocket\Events\GuildScheduledEventUserRemove::class,

        self::INTEGRATION_CREATE => \Exan\Dhp\Websocket\Events\IntegrationCreate::class,
        self::INTEGRATION_UPDATE => \Exan\Dhp\Websocket\Events\IntegrationUpdate::class,
        self::INTEGRATION_DELETE => \Exan\Dhp\Websocket\Events\IntegrationDelete::class,
        self::INTERACTION_CREATE => \Exan\Dhp\Websocket\Events\InteractionCreate::class,

        self::INVITE_CREATE => \Exan\Dhp\Websocket\Events\InviteCreate::class,
        self::INVITE_DELETE => \Exan\Dhp\Websocket\Events\InviteDelete::class,

        self::MESSAGE_CREATE => \Exan\Dhp\Websocket\Events\MessageCreate::class,
        self::MESSAGE_UPDATE => \Exan\Dhp\Websocket\Events\MessageUpdate::class,
        self::MESSAGE_DELETE => \Exan\Dhp\Websocket\Events\MessageDelete::class,
        self::MESSAGE_DELETE_BULK => \Exan\Dhp\Websocket\Events\MessageDeleteBulk::class,
        self::MESSAGE_REACTION_ADD => \Exan\Dhp\Websocket\Events\MessageReactionAdd::class,
        self::MESSAGE_REACTION_REMOVE => \Exan\Dhp\Websocket\Events\MessageReactionRemove::class,
        self::MESSAGE_REACTION_REMOVE_ALL => \Exan\Dhp\Websocket\Events\MessageReactionRemoveAll::class,
        self::MESSAGE_REACTION_REMOVE_EMOJI => \Exan\Dhp\Websocket\Events\MessageReactionRemoveEmoji::class,

        self::PRESENCE_UPDATE => \Exan\Dhp\Websocket\Events\PresenceUpdate::class,

        self::STAGE_INSTANCE_CREATE => \Exan\Dhp\Websocket\Events\StageInstanceCreate::class,
        self::STAGE_INSTANCE_UPDATE => \Exan\Dhp\Websocket\Events\StageInstanceUpdate::class,
        self::STAGE_INSTANCE_DELETE => \Exan\Dhp\Websocket\Events\StageInstanceDelete::class,

        self::TYPING_START => \Exan\Dhp\Websocket\Events\TypingStart::class,
        self::USER_UPDATE => \Exan\Dhp\Websocket\Events\UserUpdate::class,

        self::VOICE_STATE_UPDATE => \Exan\Dhp\Websocket\Events\VoiceStateUpdate::class,
        self::VOICE_SERVER_UPDATE => \Exan\Dhp\Websocket\Events\VoiceServerUpdate::class,

        self::WEBHOOKS_UPDATE => \Exan\Dhp\Websocket\Events\WebhooksUpdate::class,
    ];
}
