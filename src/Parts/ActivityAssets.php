<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#activity-object-activity-assets
 */
class ActivityAssets
{
    public string $large_image;
    public string $large_text;
    public string $small_image;
    public string $small_text;
}
