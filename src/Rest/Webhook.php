<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Ragnarok\Fenrir\Command\Helpers\InteractionCallbackBuilder;
use Ragnarok\Fenrir\Rest\Helpers\HttpHelper;
use JsonMapper;
use React\Promise\ExtendedPromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/webhook
 */
class Webhook
{
    use HttpHelper;

    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
    }

    /**
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#create-followup-message
     */
    public function createFollowUpMessage(
        string $applicationId,
        string $interactionToken,
        InteractionCallbackBuilder $interactionCallbackBuilder
    ): ExtendedPromiseInterface {
        return $this->http->post(
            Endpoint::bind(
                Endpoint::INTERACTION_RESPONSE,
                $applicationId,
                $interactionToken
            ),
            $interactionCallbackBuilder->get()
        );
    }

    /**
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#edit-original-interaction-response
     */
    public function editOriginalInteractionResponse()
    {
    }

    /**
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#delete-original-interaction-response
     */
    public function deleteOriginalInteractionResponse()
    {
    }

    /**
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#edit-followup-message
     */
    public function editFollowUpMessage()
    {
    }
}
