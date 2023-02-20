<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers;

use Exan\Fenrir\Parts\Multipart;

interface MultipartCapable
{
    public function getMultipart(): Multipart;
    public function requiresMultipart(): bool;
}
