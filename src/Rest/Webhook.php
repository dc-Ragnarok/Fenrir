<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Ragnarok\Fenrir\Interaction\Helpers\InteractionCallbackBuilder;
use Ragnarok\Fenrir\Parts\Message;
use Ragnarok\Fenrir\Parts\Webhook as PartsWebhook;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\CreateWebhookBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\EditWebhookBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\EditWebhookMessageBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\ModifyWebhookBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\WebhookBuilder;
use React\Promise\PromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/webhook
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Webhook extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#create-interaction-response
     */
    public function createInteractionResponse(
        string $interactionId,
        string $interactionToken,
        InteractionCallbackBuilder $interactionCallbackBuilder
    ): PromiseInterface {
        return $this->http->post(
            Endpoint::bind(
                Endpoint::INTERACTION_RESPONSE,
                $interactionId,
                $interactionToken
            ),
            $interactionCallbackBuilder->get()
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#get-original-interaction-response
     */
    public function getOriginalInteractionResponse(
        string $applicationId,
        string $interactionToken
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::ORIGINAL_INTERACTION_RESPONSE,
                    $applicationId,
                    $interactionToken,
                )
            ),
            Message::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#edit-original-interaction-response
     */
    public function editOriginalInteractionResponse(
        string $applicationId,
        string $interactionToken,
        EditWebhookBuilder $webhookBuilder
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::ORIGINAL_INTERACTION_RESPONSE,
                    $applicationId,
                    $interactionToken,
                ),
                $webhookBuilder->get()
            ),
            Message::class
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#delete-original-interaction-response
     */
    public function deleteOriginalInteractionResponse(
        string $applicationId,
        string $interactionToken
    ): PromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::ORIGINAL_INTERACTION_RESPONSE,
                $applicationId,
                $interactionToken
            )
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#create-webhook
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Webhook>
     */
    public function create(string $channelId, CreateWebhookBuilder $builder, ?string $reason = null): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::CHANNEL_WEBHOOKS,
                    $channelId,
                ),
                $builder->get(),
                $this->getAuditLogReasonHeader($reason),
            ),
            PartsWebhook::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#get-channel-webhooks
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Webhook[]>
     */
    public function getChannelWebhooks(string $channelId): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::CHANNEL_WEBHOOKS,
                    $channelId,
                ),
            ),
            PartsWebhook::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#get-guild-webhooks
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Webhook[]>
     */
    public function getGuildWebhooks(string $guildId)
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::GUILD_WEBHOOKS,
                    $guildId,
                ),
            ),
            PartsWebhook::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#get-webhook
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Webhook[]>
     */
    public function get(string $webhookId)
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::WEBHOOK,
                    $webhookId,
                ),
            ),
            PartsWebhook::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#get-webhook-with-token
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Webhook[]>
     */
    public function getWithToken(string $webhookId, string $token)
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::WEBHOOK_TOKEN,
                    $webhookId,
                    $token
                ),
            ),
            PartsWebhook::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#modify-webhook
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Webhook[]>
     */
    public function modify(string $webhookId, ModifyWebhookBuilder $builder, ?string $reason = null): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::WEBHOOK,
                    $webhookId,
                ),
                $builder->get(),
                $this->getAuditLogReasonHeader($reason),
            ),
            PartsWebhook::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#modify-webhook-with-token
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Webhook[]>
     */
    public function modifyWithToken(string $webhookId, string $token, ModifyWebhookBuilder $builder, ?string $reason = null): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::WEBHOOK_TOKEN,
                    $webhookId,
                    $token,
                ),
                $builder->get(),
                $this->getAuditLogReasonHeader($reason),
            ),
            PartsWebhook::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#delete-webhook
     *
     * @return PromiseInterface<void>
     */
    public function delete(string $webhookId, ?string $reason = null): PromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::WEBHOOK,
                $webhookId,
            ),
            headers: $this->getAuditLogReasonHeader($reason),
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#delete-webhook-with-token
     *
     * @return PromiseInterface<void>
     */
    public function deleteWithToken(string $webhookId, string $token, ?string $reason = null): PromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::WEBHOOK_TOKEN,
                $webhookId,
                $token,
            ),
            headers: $this->getAuditLogReasonHeader($reason),
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#execute-webhook
     *
     * @return PromiseInterface<void>
     */
    public function execute(string $webhookId, string $token, WebhookBuilder $builder, ?bool $wait = null, ?string $threadId = null): PromiseInterface
    {
        $endpoint = Endpoint::bind(
            Endpoint::WEBHOOK_EXECUTE,
            $webhookId,
            $token,
        );

        if (!is_null($wait)) {
            $endpoint->addQuery('wait', $wait);
        }

        if (!is_null($threadId)) {
            $endpoint->addQuery('thread_id', $threadId);
        }

        return $this->http->post(
            $endpoint,
            $builder->get(),
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#execute-slackcompatible-webhook
     *
     * @return PromiseInterface<void>
     */
    public function executeSlackWebhook(string $webhookId, string $token, array $params, ?bool $wait = null, ?string $threadId = null): PromiseInterface
    {
        $endpoint = Endpoint::bind(
            Endpoint::WEBHOOK_EXECUTE_SLACK,
            $webhookId,
            $token,
        );

        if (!is_null($wait)) {
            $endpoint->addQuery('wait', $wait);
        }

        if (!is_null($threadId)) {
            $endpoint->addQuery('thread_id', $threadId);
        }

        return $this->http->post(
            $endpoint,
            $params,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#execute-githubcompatible-webhook
     *
     * @return PromiseInterface<void>
     */
    public function executeGithubWebhook(string $webhookId, string $token, array $params, ?bool $wait = null, ?string $threadId = null): PromiseInterface
    {
        $endpoint = Endpoint::bind(
            Endpoint::WEBHOOK_EXECUTE_GITHUB,
            $webhookId,
            $token,
        );

        if (!is_null($wait)) {
            $endpoint->addQuery('wait', $wait);
        }

        if (!is_null($threadId)) {
            $endpoint->addQuery('thread_id', $threadId);
        }

        return $this->http->post(
            $endpoint,
            $params,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#get-webhook-message
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Message>
     */
    public function getWebhookMessage(string $webhookId, string $token, string $messageId, ?string $threadId = null): PromiseInterface
    {
        $endpoint = Endpoint::bind(
            Endpoint::WEBHOOK_MESSAGE,
            $webhookId,
            $token,
            $messageId,
        );

        if (!is_null($threadId)) {
            $endpoint->addQuery($threadId, $threadId);
        }

        return $this->mapPromise(
            $this->http->get(
                $endpoint,
            ),
            Message::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#edit-webhook-message
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Message>
     */
    public function editWebhookMessage(string $webhookId, string $token, string $messageId, EditWebhookMessageBuilder $builder, ?string $threadId = null): PromiseInterface
    {
        $endpoint = Endpoint::bind(
            Endpoint::WEBHOOK_MESSAGE,
            $webhookId,
            $token,
            $messageId,
        );

        if (!is_null($threadId)) {
            $endpoint->addQuery($threadId, $threadId);
        }

        return $this->mapPromise(
            $this->http->patch(
                $endpoint,
                $builder->get(),
            ),
            Message::class,
        )->otherwise($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/webhook#delete-webhook-message
     *
     * @return PromiseInterface<void>
     */
    public function deleteWebhookMessage(string $webhookId, string $token, string $messageId, ?string $threadId = null)
    {
        $endpoint = Endpoint::bind(
            Endpoint::WEBHOOK_MESSAGE,
            $webhookId,
            $token,
            $messageId,
        );

        if (!is_null($threadId)) {
            $endpoint->addQuery($threadId, $threadId);
        }

        $this->http->delete(
            $endpoint,
        )->otherwise($this->logThrowable(...));
    }
}
