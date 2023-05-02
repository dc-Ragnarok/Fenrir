<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Constants;

use Ragnarok\Fenrir\Gateway\Events\ApplicationCommandPermissionsUpdate;
use Ragnarok\Fenrir\Gateway\Events\AutoModerationActionExecution;
use Ragnarok\Fenrir\Gateway\Events\AutoModerationRuleCreate;
use Ragnarok\Fenrir\Gateway\Events\AutoModerationRuleDelete;
use Ragnarok\Fenrir\Gateway\Events\AutoModerationRuleUpdate;
use Ragnarok\Fenrir\Gateway\Events\ChannelCreate;
use Ragnarok\Fenrir\Gateway\Events\ChannelDelete;
use Ragnarok\Fenrir\Gateway\Events\ChannelPinsUpdate;
use Ragnarok\Fenrir\Gateway\Events\ChannelUpdate;
use Ragnarok\Fenrir\Gateway\Events\GuildBanAdd;
use Ragnarok\Fenrir\Gateway\Events\GuildBanRemove;
use Ragnarok\Fenrir\Gateway\Events\GuildCreate;
use Ragnarok\Fenrir\Gateway\Events\GuildDelete;
use Ragnarok\Fenrir\Gateway\Events\GuildEmojisUpdate;
use Ragnarok\Fenrir\Gateway\Events\GuildIntegrationsUpdate;
use Ragnarok\Fenrir\Gateway\Events\GuildMemberAdd;
use Ragnarok\Fenrir\Gateway\Events\GuildMemberRemove;
use Ragnarok\Fenrir\Gateway\Events\GuildMembersChunk;
use Ragnarok\Fenrir\Gateway\Events\GuildMemberUpdate;
use Ragnarok\Fenrir\Gateway\Events\GuildRoleCreate;
use Ragnarok\Fenrir\Gateway\Events\GuildRoleDelete;
use Ragnarok\Fenrir\Gateway\Events\GuildRoleUpdate;
use Ragnarok\Fenrir\Gateway\Events\GuildScheduledEventCreate;
use Ragnarok\Fenrir\Gateway\Events\GuildScheduledEventDelete;
use Ragnarok\Fenrir\Gateway\Events\GuildScheduledEventUpdate;
use Ragnarok\Fenrir\Gateway\Events\GuildScheduledEventUserAdd;
use Ragnarok\Fenrir\Gateway\Events\GuildScheduledEventUserRemove;
use Ragnarok\Fenrir\Gateway\Events\GuildStickersUpdate;
use Ragnarok\Fenrir\Gateway\Events\GuildUpdate;
use Ragnarok\Fenrir\Gateway\Events\IntegrationCreate;
use Ragnarok\Fenrir\Gateway\Events\IntegrationDelete;
use Ragnarok\Fenrir\Gateway\Events\IntegrationUpdate;
use Ragnarok\Fenrir\Gateway\Events\InteractionCreate;
use Ragnarok\Fenrir\Gateway\Events\InviteCreate;
use Ragnarok\Fenrir\Gateway\Events\InviteDelete;
use Ragnarok\Fenrir\Gateway\Events\MessageCreate;
use Ragnarok\Fenrir\Gateway\Events\MessageDelete;
use Ragnarok\Fenrir\Gateway\Events\MessageDeleteBulk;
use Ragnarok\Fenrir\Gateway\Events\MessageReactionAdd;
use Ragnarok\Fenrir\Gateway\Events\MessageReactionRemove;
use Ragnarok\Fenrir\Gateway\Events\MessageReactionRemoveAll;
use Ragnarok\Fenrir\Gateway\Events\MessageReactionRemoveEmoji;
use Ragnarok\Fenrir\Gateway\Events\MessageUpdate;
use Ragnarok\Fenrir\Gateway\Events\PresenceUpdate;
use Ragnarok\Fenrir\Gateway\Events\Ready;
use Ragnarok\Fenrir\Gateway\Events\StageInstanceCreate;
use Ragnarok\Fenrir\Gateway\Events\StageInstanceDelete;
use Ragnarok\Fenrir\Gateway\Events\StageInstanceUpdate;
use Ragnarok\Fenrir\Gateway\Events\ThreadCreate;
use Ragnarok\Fenrir\Gateway\Events\ThreadDelete;
use Ragnarok\Fenrir\Gateway\Events\ThreadListSync;
use Ragnarok\Fenrir\Gateway\Events\ThreadMembersUpdate;
use Ragnarok\Fenrir\Gateway\Events\ThreadMemberUpdate;
use Ragnarok\Fenrir\Gateway\Events\ThreadUpdate;
use Ragnarok\Fenrir\Gateway\Events\TypingStart;
use Ragnarok\Fenrir\Gateway\Events\UserUpdate;
use Ragnarok\Fenrir\Gateway\Events\VoiceServerUpdate;
use Ragnarok\Fenrir\Gateway\Events\VoiceStateUpdate;
use Ragnarok\Fenrir\Gateway\Events\WebhooksUpdate;

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
        self::READY => Ready::class,

        self::APPLICATION_COMMAND_PERMISSIONS_UPDATE =>
            ApplicationCommandPermissionsUpdate::class,
        self::AUTO_MODERATION_RULE_CREATE => AutoModerationRuleCreate::class,
        self::AUTO_MODERATION_RULE_UPDATE => AutoModerationRuleUpdate::class,
        self::AUTO_MODERATION_RULE_DELETE => AutoModerationRuleDelete::class,
        self::AUTO_MODERATION_ACTION_EXECUTION =>
            AutoModerationActionExecution::class,

        self::CHANNEL_CREATE => ChannelCreate::class,
        self::CHANNEL_UPDATE => ChannelUpdate::class,
        self::CHANNEL_DELETE => ChannelDelete::class,
        self::CHANNEL_PINS_UPDATE => ChannelPinsUpdate::class,

        self::THREAD_CREATE => ThreadCreate::class,
        self::THREAD_UPDATE => ThreadUpdate::class,
        self::THREAD_DELETE => ThreadDelete::class,
        self::THREAD_LIST_SYNC => ThreadListSync::class,
        self::THREAD_MEMBER_UPDATE => ThreadMemberUpdate::class,
        self::THREAD_MEMBERS_UPDATE => ThreadMembersUpdate::class,

        self::GUILD_CREATE => GuildCreate::class,
        self::GUILD_UPDATE => GuildUpdate::class,
        self::GUILD_DELETE => GuildDelete::class,

        self::GUILD_BAN_ADD => GuildBanAdd::class,
        self::GUILD_BAN_REMOVE => GuildBanRemove::class,

        self::GUILD_EMOJIS_UPDATE => GuildEmojisUpdate::class,
        self::GUILD_STICKERS_UPDATE => GuildStickersUpdate::class,

        self::GUILD_INTEGRATIONS_UPDATE => GuildIntegrationsUpdate::class,

        self::GUILD_MEMBER_ADD => GuildMemberAdd::class,
        self::GUILD_MEMBER_REMOVE => GuildMemberRemove::class,
        self::GUILD_MEMBER_UPDATE => GuildMemberUpdate::class,
        self::GUILD_MEMBERS_CHUNK => GuildMembersChunk::class,

        self::GUILD_ROLE_CREATE => GuildRoleCreate::class,
        self::GUILD_ROLE_UPDATE => GuildRoleUpdate::class,
        self::GUILD_ROLE_DELETE => GuildRoleDelete::class,

        self::GUILD_SCHEDULED_EVENT_CREATE => GuildScheduledEventCreate::class,
        self::GUILD_SCHEDULED_EVENT_UPDATE => GuildScheduledEventUpdate::class,
        self::GUILD_SCHEDULED_EVENT_DELETE => GuildScheduledEventDelete::class,
        self::GUILD_SCHEDULED_EVENT_USER_ADD => GuildScheduledEventUserAdd::class,
        self::GUILD_SCHEDULED_EVENT_USER_REMOVE =>
            GuildScheduledEventUserRemove::class,

        self::INTEGRATION_CREATE => IntegrationCreate::class,
        self::INTEGRATION_UPDATE => IntegrationUpdate::class,
        self::INTEGRATION_DELETE => IntegrationDelete::class,
        self::INTERACTION_CREATE => InteractionCreate::class,

        self::INVITE_CREATE => InviteCreate::class,
        self::INVITE_DELETE => InviteDelete::class,

        self::MESSAGE_CREATE => MessageCreate::class,
        self::MESSAGE_UPDATE => MessageUpdate::class,
        self::MESSAGE_DELETE => MessageDelete::class,
        self::MESSAGE_DELETE_BULK => MessageDeleteBulk::class,
        self::MESSAGE_REACTION_ADD => MessageReactionAdd::class,
        self::MESSAGE_REACTION_REMOVE => MessageReactionRemove::class,
        self::MESSAGE_REACTION_REMOVE_ALL => MessageReactionRemoveAll::class,
        self::MESSAGE_REACTION_REMOVE_EMOJI => MessageReactionRemoveEmoji::class,

        self::PRESENCE_UPDATE => PresenceUpdate::class,

        self::STAGE_INSTANCE_CREATE => StageInstanceCreate::class,
        self::STAGE_INSTANCE_UPDATE => StageInstanceUpdate::class,
        self::STAGE_INSTANCE_DELETE => StageInstanceDelete::class,

        self::TYPING_START => TypingStart::class,
        self::USER_UPDATE => UserUpdate::class,

        self::VOICE_STATE_UPDATE => VoiceStateUpdate::class,
        self::VOICE_SERVER_UPDATE => VoiceServerUpdate::class,

        self::WEBHOOKS_UPDATE => WebhooksUpdate::class,
    ];
}
