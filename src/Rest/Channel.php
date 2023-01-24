<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Exan\Dhp\Parts\Channel as PartsChannel;
use Exan\Dhp\Parts\Emoji;
use Exan\Dhp\Parts\Message;
use Exan\Dhp\Rest\Helpers\HttpHelper;
use Exan\Dhp\Rest\Helpers\MessageBuilder;
use JsonMapper;
use React\Promise\Promise;

class Channel
{
    use HttpHelper;

    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#get-channel
     *
     * @return Promise<Exan\Dhp\Parts\Channel>
     */
    public function get(string $channelId): Promise
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::CHANNEL,
                    $channelId
                )
            ),
            PartsChannel::class
        );
    }

    /**
     * @todo
     */
    public function modify()
    {

    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#deleteclose-channel
     *
     * @return Promise<Exan\Dhp\Parts\Channel>
     */
    public function delete(string $channelId, ?string $reason = null): Promise
    {
        return $this->mapPromise(
            $this->http->delete(
                Endpoint::bind(
                    Endpoint::CHANNEL,
                    $channelId
                ),
                null,
                $this->getAuditLogReasonHeader($reason)
            ),
            PartsChannel::class
        );
    }

    /**
     * @todo
     */
    public function getMessages()
    {

    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#get-channel-message
     *
     * @return Promise<Exan\Dhp\Parts\Message>
     */
    public function getMessage(string $channelId, string $messageId): Promise
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::CHANNEL_MESSAGE,
                    $channelId,
                    $messageId
                )
            ),
            Message::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#create-message
     *
     * @return Promise<Exan\Dhp\Parts\Message>
     */
    public function createMessage(string $channelId, MessageBuilder $message): Promise
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

    /**
     * @todo
     */
    public function crosspostMessage()
    {

    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#create-reaction
     */
    public function createReaction(string $channelId, string $messageId, Emoji $emoji): Promise
    {
        return $this->http->put(
            Endpoint::bind(
                Endpoint::MESSAGE_REACTION_EMOJI,
                $channelId,
                $messageId,
                (string) $emoji
            )
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#delete-own-reaction
     */
    public function deleteOwnReaction(string $channelId, string $messageId, Emoji $emoji): Promise
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::OWN_MESSAGE_REACTION,
                $channelId,
                $messageId,
                (string) $emoji
            )
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#delete-user-reaction
     */
    public function deleteUserReaction(string $channelId, string $messageId, Emoji $emoji, string $userId): Promise
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::USER_MESSAGE_REACTION,
                $channelId,
                $messageId,
                (string) $emoji,
                $userId
            )
        );
    }

    /**
     * @todo
     */
    public function getReactions()
    {

    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#delete-all-reactions
     */
    public function deleteAllReactions(string $channelId, string $messageId): Promise
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::MESSAGE_REACTION_ALL,
                $channelId,
                $messageId
            )
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#delete-all-reactions-for-emoji
     */
    public function deleteAllReactionsForEmoji(string $channelId, string $messageId, Emoji $emoji)
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::MESSAGE_REACTION_EMOJI,
                $channelId,
                $messageId,
                (string) $emoji
            )
        );
    }

    /**
     * @todo
     */
    public function editMessage()
    {

    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#bulk-delete-messages
     *
     * @var string[] $messageIds
     */
    public function bulkDeleteMessages(string $channelId, array $messageIds, ?string $reason = null)
    {
        return $this->http->post(
            Endpoint::bind(
                Endpoint::CHANNEL_MESSAGES_BULK_DELETE,
                $channelId
            ),
            $messageIds,
            $this->getAuditLogReasonHeader($reason)
        );
    }

    /**
     * @todo
     */
    public function editChannelPermissions()
    {

    }

    /**
     * @todo
     */
    public function getChannelInvites()
    {

    }

    /**
     * @todo
     */
    public function createChannelInvite()
    {

    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#delete-channel-permission
     */
    public function deleteChannelPermissions(string $channelId, string $overwriteId, ?string $reason = null)
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::CHANNEL_PERMISSIONS,
                $channelId,
                $overwriteId
            ),
            null,
            $this->getAuditLogReasonHeader($reason)
        );
    }

    /**
     * @todo
     */
    public function followAnnouncementChannel()
    {

    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#trigger-typing-indicator
     */
    public function triggerTypingIndicator(string $channelId)
    {
        return $this->http->post(
            Endpoint::bind(
                Endpoint::CHANNEL_TYPING,
                $channelId
            )
        );
    }

    /**
     * @todo
     */
    public function getPinnedMessages()
    {

    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#pin-message
     */
    public function pinMessage(string $channelId, string $messageId)
    {
        return $this->http->put(
            Endpoint::bind(
                Endpoint::CHANNEL_PIN,
                $channelId,
                $messageId
            )
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#unpin-message
     */
    public function unpinMessage(string $channelId, string $messageId)
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::CHANNEL_PIN,
                $channelId,
                $messageId
            )
        );
    }

    /**
     * @todo
     */
    public function startThreadFromMessage()
    {

    }

    /**
     * @todo
     */
    public function startThreadWithoutMessage()
    {

    }

    /**
     * @todo
     */
    public function startThreadInForumChannel()
    {

    }

    /**
     * @todo
     */
    public function joinThread()
    {

    }

    /**
     * @todo
     */
    public function addThreadMember()
    {

    }

    /**
     * @todo
     */
    public function leaveThread()
    {

    }

    /**
     * @todo
     */
    public function removeThreadMember()
    {

    }

    /**
     * @todo
     */
    public function getThreadMember()
    {

    }

    /**
     * @todo
     */
    public function listThreadMembers()
    {

    }

    /**
     * @todo
     */
    public function listPublicArchivedThreads()
    {

    }

    /**
     * @todo
     */
    public function listPrivateArchivedThreads()
    {

    }

    /**
     * @todo
     */
    public function listJoinedPrivateArchivedThreads()
    {

    }
}
