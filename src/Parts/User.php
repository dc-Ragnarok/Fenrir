<?php

namespace Exan\Dhp\Parts;

use \Exan\Dhp\Enums\Parts\PremiumTypes;

class User
{
    public string $id;
    public string $username;
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
    public ?string $flags;
    public ?PremiumTypes $premium_type;
    public ?string $public_flags;

    public function setPremiumType(int $value): void
    {
        $this->premium_type = PremiumTypes::from($value);
    }
}
