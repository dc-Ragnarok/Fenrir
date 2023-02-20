<?php

declare(strict_types=1);

namespace Exan\Finrir\Enums\Parts;

enum Scopes: string
{
    case ACTIVITIES_READ = 'activities.read';
    case ACTIVITIES_WRITE = 'activities.write';
    case APPLICATIONS_BUILDS_READ = 'applications.builds.read';
    case APPLICATIONS_BUILDS_UPLOAD = 'applications.builds.upload';
    case APPLICATIONS_COMMANDS = 'applications.commands';
    case APPLICATIONS_COMMANDS_UPDATE = 'applications.commands.update';
    case APPLICATIONS_COMMANDS_PERMISSIONS_UPDATE = 'applications.commands.permissions.update';
    case APPLICATIONS_ENTITLEMENTS = 'applications.entitlements';
    case APPLICATIONS_STORE_UPDATE = 'applications.store.update';
    case BOT = 'bot';
    case CONNECTIONS = 'connections';
    case DM_CHANNELS_READ = 'dm_channels.read';
    case EMAIL = 'email';
    case GDM_JOIN = 'gdm.join';
    case GUILDS = 'guilds';
    case GUILDS_JOIN = 'guilds.join';
    case GUILDS_MEMBERS_READ = 'guilds.members.read';
    case IDENTIFY = 'identify';
    case MESSAGES_READ = 'messages.read';
    case RELATIONSHIPS_READ = 'relationships.read';
    case ROLE_CONNECTIONS_WRITE = 'role_connections.write';
    case RPC = 'rpc';
    case RPC_ACTIVITIES_WRITE = 'rpc.activities.write';
    case RPC_NOTIFICATIONS_READ = 'rpc.notifications.read';
    case RPC_VOICE_READ = 'rpc.voice.read';
    case RPC_VOICE_WRITE = 'rpc.voice.write';
    case VOICE = 'voice';
    case WEBHOOK_INCOMING = 'webhook.incoming';
}
