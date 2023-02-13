<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Exan\Dhp\Parts\Channel as PartsChannel;
use Exan\Dhp\Parts\Emoji;
use Exan\Dhp\Parts\Invite;
use Exan\Dhp\Parts\Message;
use Exan\Dhp\Parts\User;
use Exan\Dhp\Rest\Helpers\Channel\Channel\ChannelBuilder;
use Exan\Dhp\Rest\Helpers\Channel\GetMessagesBuilder;
use Exan\Dhp\Rest\Helpers\Channel\GetReactionsBuilder;
use Exan\Dhp\Rest\Helpers\Channel\InviteBuilder;
use Exan\Dhp\Rest\Helpers\Channel\MessageBuilder;
use Exan\Dhp\Rest\Helpers\Channel\StartThreadFromMessageBuilder;
use Exan\Dhp\Rest\Helpers\Emoji\EmojiBuilder;
use Exan\Dhp\Rest\Helpers\HttpHelper;
use JsonMapper;
use React\Promise\ExtendedPromiseInterface;

class Channel
{
    use HttpHelper;

    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#get-channel
     *
     * @return ExtendedPromiseInterface<\Exan\Dhp\Parts\Channel>
     */
    public function get(string $channelId): ExtendedPromiseInterface
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
     * @see https://discord.com/developers/docs/resources/channel#modify-channel
     *
     * @return ExtendedPromiseInterface<\Exan\Dhp\Parts\Channel>
     */
    public function modify(string $channelId, ChannelBuilder $channel, ?string $reason = null)
    {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::CHANNEL,
                    $channelId
                ),
                $channel->get(),
                $this->getAuditLogReasonHeader($reason)
            ),
            PartsChannel::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#deleteclose-channel
     *
     * @return ExtendedPromiseInterface<\Exan\Dhp\Parts\Channel>
     */
    public function delete(string $channelId, ?string $reason = null): ExtendedPromiseInterface
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
     * @see https://discord.com/developers/docs/resources/channel#get-channel-messages
     *
     * @return ExtendedPromiseInterface<\Exan\Dhp\Parts\Message[]>
     */
    public function getMessages(
        string $channelId,
        GetMessagesBuilder $getMessagesBuilder = new GetMessagesBuilder()
    ): ExtendedPromiseInterface {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::CHANNEL_MESSAGES,
                    $channelId
                ),
                $getMessagesBuilder->get()
            ),
            Message::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#get-channel-message
     *
     * @return ExtendedPromiseInterface<\Exan\Dhp\Parts\Message>
     */
    public function getMessage(string $channelId, string $messageId): ExtendedPromiseInterface
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
     * @return ExtendedPromiseInterface<\Exan\Dhp\Parts\Message>
     */
    public function createMessage(
        string $channelId,
        MessageBuilder $message
    ): ExtendedPromiseInterface {
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
     * @see https://discord.com/developers/docs/resources/channel#crosspost-message
     *
     * @return ExtendedPromiseInterface<\Exan\Dhp\Parts\Message>
     */
    public function crosspostMessage(string $channelId, string $messageId): ExtendedPromiseInterface
    {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::CHANNEL_CROSSPOST_MESSAGE,
                    $channelId,
                    $messageId
                )
            ),
            Message::class,
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#create-reaction
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function createReaction(
        string $channelId,
        string $messageId,
        EmojiBuilder $emoji
    ): ExtendedPromiseInterface {
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
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function deleteOwnReaction(
        string $channelId,
        string $messageId,
        EmojiBuilder $emoji
    ): ExtendedPromiseInterface {
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
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function deleteUserReaction(
        string $channelId,
        string $messageId,
        EmojiBuilder $emoji,
        string $userId
    ): ExtendedPromiseInterface {
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
     * @see https://discord.com/developers/docs/resources/channel#get-reactions
     *
     * @return ExtendedPromiseInterface<\Exan\Dhp\Parts\Message>
     */
    public function getReactions(
        string $channelId,
        string $messageId,
        EmojiBuilder $emoji,
        GetReactionsBuilder $getReactionsBuilder = new GetReactionsBuilder()
    ) {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::CHANNEL_MESSAGES,
                    $channelId,
                    $messageId,
                    (string) $emoji
                ),
                $getReactionsBuilder->get()
            ),
            User::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#delete-all-reactions
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function deleteAllReactions(string $channelId, string $messageId): ExtendedPromiseInterface
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
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function deleteAllReactionsForEmoji(
        string $channelId,
        string $messageId,
        EmojiBuilder $emoji
    ): ExtendedPromiseInterface {
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
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function bulkDeleteMessages(
        string $channelId,
        array $messageIds,
        ?string $reason = null
    ): ExtendedPromiseInterface {
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
     * @see https://discord.com/developers/docs/resources/invite#invite-object
     *
     * @return ExtendedPromiseInterface<\Exan\Dhp\Parts\Invite>
     */
    public function getChannelInvites(string $channelId): ExtendedPromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::CHANNEL_INVITES,
                    $channelId
                )
            ),
            Invite::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#get-channel-invites
     *
     * @return ExtendedPromiseInterface<\Exan\Dhp\Parts\Invite>
     */
    public function createChannelInvite(
        string $channelId,
        InviteBuilder $inviteBuilder = new InviteBuilder(),
        ?string $reason = null
    ): ExtendedPromiseInterface {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::CHANNEL_INVITES,
                    $channelId
                ),
                $inviteBuilder->get(),
                $this->getAuditLogReasonHeader($reason)
            ),
            Invite::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#delete-channel-permission
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function deleteChannelPermissions(
        string $channelId,
        string $overwriteId,
        ?string $reason = null
    ): ExtendedPromiseInterface {
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
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function triggerTypingIndicator(string $channelId): ExtendedPromiseInterface
    {
        return $this->http->post(
            Endpoint::bind(
                Endpoint::CHANNEL_TYPING,
                $channelId
            )
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#get-pinned-messages
     *
     * @return ExtendedPromiseInterface<\Exan\Dhp\Parts\Message[]>
     */
    public function getPinnedMessages(string $channelId)
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::CHANNEL_PINS,
                    $channelId
                )
            ),
            Message::class
        );
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#pin-message
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function pinMessage(string $channelId, string $messageId): ExtendedPromiseInterface
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
     *
     * @return ExtendedPromiseInterface<void>
     */
    public function unpinMessage(string $channelId, string $messageId): ExtendedPromiseInterface
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
     * @see https://discord.com/developers/docs/resources/channel#start-thread-from-message
     *
     * @return ExtendedPromiseInterface<\Exan\Dhp\Parts\Channel>
     */
    public function startThreadFromMessage(
        string $channelId,
        string $messageId,
        StartThreadFromMessageBuilder $startThreadFromMessageBuilder
    ) {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::CHANNEL_MESSAGE_THREADS,
                    $channelId,
                    $messageId,
                ),
                $startThreadFromMessageBuilder->get()
            ),
            PartsChannel::class
        );
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
