<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers;

use Exan\Finrir\Parts\Multipart;

interface MultipartCapable
{
    public function getMultipart(): Multipart;
    public function requiresMultipart(): bool;
}
