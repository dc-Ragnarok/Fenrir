<?php

declare(strict_types=1);

namespace Exan\Fenrir\Enums;

enum Permissions: int
{
    case CREATE_INSTANT_INVITE = 1 << 0;
    case KICK_MEMBERS = 1 << 1;
    case BAN_MEMBERS = 1 << 2;
    case ADMINISTRATOR = 1 << 3;
    case MANAGE_CHANNELS = 1 << 4;
    case MANAGE_GUILD = 1 << 5;
    case ADD_REACTIONS = 1 << 6;
    case VIEW_AUDIT_LOG = 1 << 7;
    case PRIORITY_SPEAKER = 1 << 8;
    case STREAM = 1 << 9;
    case VIEW_CHANNEL = 1 << 10;
    case SEND_MESSAGES = 1 << 11;
    case SEND_TTS_MESSAGES = 1 << 12;
    case MANAGE_MESSAGES = 1 << 13;
    case EMBED_LINKS = 1 << 14;
    case ATTACH_FILES = 1 << 15;
    case READ_MESSAGE_HISTORY = 1 << 16;
    case MENTION_EVERYONE = 1 << 17;
    case USE_EXTERNAL_EMOJIS = 1 << 18;
    case VIEW_GUILD_INSIGHTS = 1 << 19;
    case CONNECT = 1 << 20;
    case SPEAK = 1 << 21;
    case MUTE_MEMBERS = 1 << 22;
    case DEAFEN_MEMBERS = 1 << 23;
    case MOVE_MEMBERS = 1 << 24;
    case USE_VAD = 1 << 25;
    case CHANGE_NICKNAME = 1 << 26;
    case MANAGE_NICKNAMES = 1 << 27;
    case MANAGE_ROLES = 1 << 28;
    case MANAGE_WEBHOOKS = 1 << 29;
    case MANAGE_EMOJIS_AND_STICKERS = 1 << 30;
    case USE_APPLICATION_COMMANDS = 1 << 31;
    case REQUEST_TO_SPEAK = 1 << 32;
    case MANAGE_EVENTS = 1 << 33;
    case MANAGE_THREADS = 1 << 34;
    case CREATE_PUBLIC_THREADS = 1 << 35;
    case CREATE_PRIVATE_THREADS = 1 << 36;
    case USE_EXTERNAL_STICKERS = 1 << 37;
    case SEND_MESSAGES_IN_THREADS = 1 << 38;
    case USE_EMBEDDED_ACTIVITIES = 1 << 39;
    case MODERATE_MEMBERS = 1 << 40;
}
