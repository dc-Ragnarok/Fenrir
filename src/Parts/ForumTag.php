<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

class ForumTag
{
    public string $id;
    public string $name;
    public bool $moderated;
    public ?string $emoji_id;
    public ?string $emoji_name;
}
