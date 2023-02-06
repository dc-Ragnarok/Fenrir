<?php

namespace Exan\Dhp\Parts;

/**
 * @see https://discord.com/developers/docs/resources/voice#voice-region-object
 */
class VoiceRegion
{
    public string $id;
    public string $name;
    public bool $optimal;
    public bool $deprecated;
    public bool $custom;
}
