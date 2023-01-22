<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Exan\Dhp\Parts\Message;
use Exan\Dhp\Rest\Helpers\MessageBuilder;
use JsonMapper;

class Channel
{
    use MapPromises;

    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
    }

    public function createMessage(string $channelId, MessageBuilder $message)
    {
        return $this->mapPromise((function () use ($channelId, $message) {
            if ($message->requiresMultipart()) {
                $multipart = $message->getMultipart();

                $body = $multipart->getBody();
                $headers = $multipart->getHeaders($body);

                return $this->http->post(
                    Endpoint::bind(
                        Endpoint::CHANNEL_MESSAGES,
                        $channelId
                    ),
                    $body . "\n",
                    $headers
                );
            }

            return $this->http->post(
                Endpoint::bind(
                    Endpoint::CHANNEL_MESSAGES,
                    $channelId
                ),
                $message->get()
            );
        })(), Message::class);
    }
}
