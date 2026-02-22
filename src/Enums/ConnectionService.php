<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum ConnectionService: string
{
    case AmazonMusic = 'amazon-music';
    case BattleNet = 'battlenet';
    case Bungie = 'bungie';
    case Bluesky = 'bluesky';
    case Crunchyroll = 'crunchyroll';
    case Domain = 'domain';
    case Ebay = 'ebay';
    case EpicGames = 'epicgames';
    case Facebook = 'facebook';
    case GitHub = 'github';
    case Instagram = 'instagram';
    case LeagueOfLegends = 'leagueoflegends';
    case Mastodon = 'mastodon';
    case PayPal = 'paypal';
    case PlayStation = 'playstation';
    case Reddit = 'reddit';
    case RiotGames = 'riotgames';
    case Roblox = 'roblox';
    case Spotify = 'spotify';
    case Skype = 'skype';
    case Steam = 'steam';
    case TikTok = 'tiktok';
    case Twitch = 'twitch';
    case Twitter = 'twitter';
    case Xbox = 'xbox';
    case YouTube = 'youtube';
}
