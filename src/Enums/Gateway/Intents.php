<?php

declare(strict_types=1);

namespace Exan\Dhp\Enums\Gateway;

/**
 * @see https://discord.com/developers/docs/topics/gateway#gateway-intents
 */
enum Intents: int
{
    case GUILDS = 1 << 0;
    case GUILD_MEMBERS = 1 << 1;
    case GUILD_MODERATION = 1 << 2;
    case GUILD_EMOJIS_AND_STICKERS = 1 << 3;
    case GUILD_INTEGRATIONS = 1 << 4;
    case GUILD_WEBHOOKS = 1 << 5;
    case GUILD_INVITES = 1 << 6;
    case GUILD_VOICE_STATES = 1 << 7;
    case GUILD_PRESENCES = 1 << 8;
    case GUILD_MESSAGES = 1 << 9;
    case GUILD_MESSAGE_REACTIONS = 1 << 10;
    case GUILD_MESSAGE_TYPING = 1 << 11;
    case DIRECT_MESSAGES = 1 << 12;
    case DIRECT_MESSAGE_REACTIONS = 1 << 13;
    case DIRECT_MESSAGE_TYPING = 1 << 14;
    case MESSAGE_CONTENT = 1 << 15;
    case GUILD_SCHEDULED_EVENTS = 1 << 16;
    case AUTO_MODERATION_CONFIGURATION = 1 << 20;
    case AUTO_MODERATION_EXECUTION = 1 << 21;
}
