<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

class VoiceRegion
{
    public string $id;
    public string $name;
    public bool $optimal;
    public bool $deprecated;
    public bool $custom;
}
