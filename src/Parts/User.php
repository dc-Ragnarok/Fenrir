<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Attributes\Partial;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Enums\PremiumTier;

class User
{
    public string $id;
    public string $username;
    public ?string $global_name;
    public string $discriminator;
    public ?string $avatar;
    public ?bool $bot;
    public ?bool $system;
    public ?bool $mfa_enabled;
    public ?string $banner;
    public ?int $accent_color;
    public ?string $locale;
    public bool $verified;
    public ?string $email;
    public ?Bitwise $flags;
    public ?PremiumTier $premium_type;
    public ?Bitwise $public_flags;
    public ?GuildMember $member;

    public function setPremiumType(int $value): void
    {
        $this->premium_type = PremiumTier::from($value);
    }
}
