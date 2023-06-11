<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\Parts\InteractionTypes;

class Interaction
{
    public string $id;
    public string $application_id;
    public InteractionTypes $type;
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

    /**
     * @partial
     */
    public Channel $channel;

    public function setType(int $value): void
    {
        $this->type = InteractionTypes::from($value);
    }
}
