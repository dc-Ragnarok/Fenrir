<?php

declare(strict_types=1);

namespace Exan\Finrir\Enums\Parts;

enum StickerFormatTypes: int
{
    case PNG = 1;
    case APNG = 2;
    case LOTTIE = 3;
    case GIF = 4;
}
