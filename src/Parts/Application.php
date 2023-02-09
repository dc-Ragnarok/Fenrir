<?php

namespace Exan\Dhp\Parts;


class Application
{
    public string $id;
    public string $name;
    public ?string $icon;
    public string $description;
    /** @var ?\Exan\Dhp\Parts\string[] */
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
    public ?string $flags;
    /** @var ?\Exan\Dhp\Parts\string[] */
    public ?array $tags;
    public ?InstallParams $install_params;
    public ?string $custom_install_url;
    public ?string $role_connections_verification_url;
}
