<?php

namespace Exan\Dhp\Rest\Helpers;

use Exan\Dhp\Parts\Multipart;

interface MultipartCapable
{
    public function getMultipart(): Multipart;
    public function requiresMultipart(): bool;
}
