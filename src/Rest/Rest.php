<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest;

use Discord\Http\Http;
use JsonMapper;

class Rest
{
    public Channel $channel;

    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
        $this->channel = new Channel($this->http, $this->jsonMapper);
    }
}
