<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Bitwise\Bitwise;
use Exan\Fenrir\Attributes\Partial;

class Application
{
    public string $id;
    public string $name;
    public ?string $icon;
    public string $description;
    /**
     * @var string[]
     */
    public ?array $rpc_origins;
    public bool $bot_public;
    public bool $bot_require_code_grant;
    public ?string $terms_of_service_url;
    public ?string $privacy_policy_url;
    #[Partial]
    public ?User $owner;
    public string $verify_key;
    public ?Team $team;
    public ?string $guild_id;
    public ?string $primary_sku_id;
    public ?string $slug;
    public ?string $cover_image;
    public ?Bitwise $flags;
    /**
     * @var string[]
     */
    public ?array $tags;
    public ?InstallParams $install_params;
    public ?string $custom_install_url;
    public ?string $role_connections_verification_url;
}
