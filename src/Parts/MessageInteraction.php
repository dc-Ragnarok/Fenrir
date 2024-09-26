<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\InteractionType;

/**
 * @see https://discord.com/developers/docs/resources/message#message-interaction-metadata-object-message-interaction-metadata-structure
 */
class MessageInteraction
{
    public string $id;
    public InteractionType $type;
    public User $user;
    /**
     * @var string[]
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#interaction-object-authorizing-integration-owners-object
     */
    public array $authorizing_integration_owners;
    public ?string $original_response_message_id;
    public ?string $interacted_message_id;
    public ?self $triggering_interaction_metadata;
}
