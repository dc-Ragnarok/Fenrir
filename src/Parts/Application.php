<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

/**
 * @see https://discord.com/developers/docs/resources/application#application-object
 */
class Application
{
    public string $id;
    public string $name;
    public ?string $icon;
    public string $description;

    /**
     * @var string[]
     */
    public array $rpc_origins;
    public bool $bot_public;
    public bool $bot_require_code_grant;
    public ?string $terms_of_service_url;
    public ?string $privacy_policy_url;

    /**
     * Partial
     */
    public ?User $owner;

    /**
     * @var string
     * @deprecated
     */
    public string $summary;

    public string $verify_key;

    /**
     * @see https://discord.com/developers/docs/topics/teams#data-models-team-object
     * @todo proper type
     */
    public ?object $team;

    public ?string $guild_id;
    public ?string $primary_sku_id;
    public ?string $slug;
    public ?string $cover_image;
    public ?int $flags;

    /**
     * @var string[]
     */
    public array $tags;

    /**
     * @see https://discord.com/developers/docs/resources/application#install-params-object
     * @todo proper type
     */
    public ?object $install_params;

    public ?string $custom_install_url;
    public ?string $role_connections_verification_url;
}
