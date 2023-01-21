<?php

namespace Exan\Dhp\Rest;

use Discord\Http\Http;
use Exan\Dhp\Rest\Message;

class Rest
{
    public Message $message;

    public function __construct(private Http $http)
    {
        $this->message = new Message($this->http);
    }
}
