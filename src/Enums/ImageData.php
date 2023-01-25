<?php

declare(strict_types=1);

namespace Exan\Dhp\Enums;

enum ImageData: string
{
    case JPG = 'image/jpeg';
    case PNG = 'image/png';
    case GIF = 'image/gif';
}
