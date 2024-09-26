<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

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
    public ?User $owner;
    public string $verify_key;
    public ?Team $team;
    public ?string $guild_id;
    public ?string $primary_sku_id;
    public ?string $slug;
    public ?string $cover_image;
    public ?Bitwise $flags;
    public ?int $approximate_guild_count;
    public ?int $approximate_user_install_count;
    /**
     * @var string[]
     */
    public ?array $redirect_uris;
    /**
     * @var string[]
     */
    public ?array $tags;
    public ?InstallParams $install_params;
    public ?string $custom_install_url;
    public ?string $role_connections_verification_url;
    /**
     * @var ApplicationIntegrationType[]
     */
    #[ArrayMapping(ApplicationIntegrationType::class)]
    public ?array $integration_types_config;
}
