<?php

namespace Exan\Dhp\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;

class Message
{
    public function __construct(private Http $http)
    {

    }

    public function send(string $channelId, string $content)
    {
        return $this->http->post(
            Endpoint::bind(
                Endpoint::CHANNEL_MESSAGES,
                $channelId
            ),
            [
                'content' => $content
            ]
        );
    }
}
