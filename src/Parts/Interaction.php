<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\InteractionContextType;
use Ragnarok\Fenrir\Enums\InteractionType;

class Interaction
{
    public string $id;
    public string $application_id;
    public InteractionType $type;
    public ?InteractionData $data;
    public ?string $guild_id;
    /** @deprecated */
    public ?string $channel_id;
    public ?GuildMember $member;
    public User $user;
    public string $token;
    public int $version;
    public ?Message $message;
    public ?string $app_permissions;
    public ?string $locale;
    public string $guild_locale;
    public Channel $channel;
    public InteractionContextType $context;
    /**
     * @var string[]
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#interaction-object-authorizing-integration-owners-object
     */
    public array $authorizing_integration_owners;
}
