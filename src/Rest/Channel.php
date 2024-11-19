<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Endpoint;
use Discord\Http\Multipart\MultipartBody;
use Ragnarok\Fenrir\Parts\Channel as PartsChannel;
use Ragnarok\Fenrir\Parts\Invite;
use Ragnarok\Fenrir\Parts\Message;
use Ragnarok\Fenrir\Parts\ThreadMember;
use Ragnarok\Fenrir\Parts\User;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\ChannelBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\EditMessageBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\EditPermissionsBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\GetMessagesBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\GetReactionsBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\InviteBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\MessageBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\StartThreadFromMessageBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\StartThreadWithoutMessageBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\EmojiBuilder;
use React\Promise\PromiseInterface;

/**
 * @see https://discord.com/developers/docs/resources/channel
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 *
 * @todo seperate calls, `$this->reaction->create(...)` instead of `$this->createReaction(...)` etc
 */
class Channel extends HttpResource
{
    /**
     * @see https://discord.com/developers/docs/resources/channel#get-channel
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Channel>
     */
    public function get(string $channelId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::CHANNEL,
                    $channelId
                )
            ),
            PartsChannel::class
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#modify-channel
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Channel>
     */
    public function modify(string $channelId, ChannelBuilder $channel, ?string $reason = null): PromiseInterface
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
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#deleteclose-channel
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Channel>
     */
    public function delete(string $channelId, ?string $reason = null): PromiseInterface
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
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#get-channel-messages
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Message[]>
     */
    public function getMessages(
        string $channelId,
        GetMessagesBuilder $getMessagesBuilder = new GetMessagesBuilder()
    ): PromiseInterface {
        $endpoint = Endpoint::bind(
            Endpoint::CHANNEL_MESSAGES,
            $channelId
        );

        $queryParams = $getMessagesBuilder->get();
        foreach ($queryParams as $key => $value) {
            $endpoint->addQuery($key, $value);
        }

        return $this->mapArrayPromise(
            $this->http->get($endpoint),
            Message::class
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#get-channel-message
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Message>
     */
    public function getMessage(string $channelId, string $messageId): PromiseInterface
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
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#create-message
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Message>
     */
    public function createMessage(
        string $channelId,
        MessageBuilder $message
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::CHANNEL_MESSAGES,
                    $channelId
                ),
                $message->get()
            ),
            Message::class
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#crosspost-message
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Message>
     */
    public function crosspostMessage(string $channelId, string $messageId): PromiseInterface
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
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#create-reaction
     *
     * @return PromiseInterface<void>
     */
    public function createReaction(
        string $channelId,
        string $messageId,
        EmojiBuilder $emoji
    ): PromiseInterface {
        return $this->http->put(
            Endpoint::bind(
                Endpoint::OWN_MESSAGE_REACTION,
                $channelId,
                $messageId,
                (string) $emoji
            )
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#delete-own-reaction
     *
     * @return PromiseInterface<void>
     */
    public function deleteOwnReaction(
        string $channelId,
        string $messageId,
        EmojiBuilder $emoji
    ): PromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::OWN_MESSAGE_REACTION,
                $channelId,
                $messageId,
                (string) $emoji
            )
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#delete-user-reaction
     *
     * @return PromiseInterface<void>
     */
    public function deleteUserReaction(
        string $channelId,
        string $messageId,
        EmojiBuilder $emoji,
        string $userId
    ): PromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::USER_MESSAGE_REACTION,
                $channelId,
                $messageId,
                (string) $emoji,
                $userId
            )
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#get-reactions
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Message>
     */
    public function getReactions(
        string $channelId,
        string $messageId,
        EmojiBuilder $emoji,
        GetReactionsBuilder $getReactionsBuilder = new GetReactionsBuilder()
    ): PromiseInterface {
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
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#delete-all-reactions
     *
     * @return PromiseInterface<void>
     */
    public function deleteAllReactions(string $channelId, string $messageId): PromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::MESSAGE_REACTION_ALL,
                $channelId,
                $messageId
            )
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#delete-all-reactions-for-emoji
     *
     * @return PromiseInterface<void>
     */
    public function deleteAllReactionsForEmoji(
        string $channelId,
        string $messageId,
        EmojiBuilder $emoji
    ): PromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::MESSAGE_REACTION_EMOJI,
                $channelId,
                $messageId,
                (string) $emoji
            )
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#edit-message
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Message>
     */
    public function editMessage(
        string $channelId,
        string $messageId,
        EditMessageBuilder $message
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->patch(
                Endpoint::bind(
                    Endpoint::CHANNEL_MESSAGE,
                    $channelId,
                    $messageId
                ),
                $message->get()
            ),
            Message::class
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#delete-message
     *
     * @return PromiseInterface<void>
     */
    public function deleteMessage(
        string $channelId,
        string $messageId,
        ?string $reason = null,
    ): PromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::CHANNEL_MESSAGE,
                $channelId,
                $messageId
            ),
            headers: $this->getAuditLogReasonHeader($reason),
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#bulk-delete-messages
     *
     * @var string[] $messageIds
     *
     * @return PromiseInterface<void>
     */
    public function bulkDeleteMessages(
        string $channelId,
        array $messageIds,
        ?string $reason = null
    ): PromiseInterface {
        return $this->http->post(
            Endpoint::bind(
                Endpoint::CHANNEL_MESSAGES_BULK_DELETE,
                $channelId
            ),
            ['messages' => $messageIds],
            $this->getAuditLogReasonHeader($reason)
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#edit-channel-permissions
     *
     * @return PromiseInterface<void>
     */
    public function editChannelPermissions(
        string $channelId,
        EditPermissionsBuilder $editPermissionsBuilder,
        ?string $reason = null
    ): PromiseInterface {
        return $this->http->put(
            Endpoint::bind(
                Endpoint::CHANNEL_PERMISSIONS,
                $channelId,
                $editPermissionsBuilder->getOverwriteId()
            ),
            $editPermissionsBuilder->get(),
            $this->getAuditLogReasonHeader($reason)
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/invite#invite-object
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Invite>
     */
    public function getChannelInvites(string $channelId): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::CHANNEL_INVITES,
                    $channelId
                )
            ),
            Invite::class
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#get-channel-invites
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Invite>
     */
    public function createChannelInvite(
        string $channelId,
        InviteBuilder $inviteBuilder = new InviteBuilder(),
        ?string $reason = null
    ): PromiseInterface {
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
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#delete-channel-permission
     *
     * @return PromiseInterface<void>
     */
    public function deleteChannelPermissions(
        string $channelId,
        string $overwriteId,
        ?string $reason = null
    ): PromiseInterface {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::CHANNEL_PERMISSIONS,
                $channelId,
                $overwriteId
            ),
            null,
            $this->getAuditLogReasonHeader($reason)
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#follow-announcement-channel
     *
     * @return PromiseInterface<void>
     */
    public function followAnnouncementChannel(string $channelId, string $webhookChannelId): PromiseInterface
    {
        return $this->http->post(
            Endpoint::bind(
                Endpoint::CHANNEL_FOLLOW,
                $channelId
            ),
            ['webhook_channel_id' => $webhookChannelId]
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#trigger-typing-indicator
     *
     * @return PromiseInterface<void>
     */
    public function triggerTypingIndicator(string $channelId): PromiseInterface
    {
        return $this->http->post(
            Endpoint::bind(
                Endpoint::CHANNEL_TYPING,
                $channelId
            )
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#get-pinned-messages
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Message[]>
     */
    public function getPinnedMessages(string $channelId): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::CHANNEL_PINS,
                    $channelId
                )
            ),
            Message::class
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#pin-message
     *
     * @return PromiseInterface<void>
     */
    public function pinMessage(string $channelId, string $messageId): PromiseInterface
    {
        return $this->http->put(
            Endpoint::bind(
                Endpoint::CHANNEL_PIN,
                $channelId,
                $messageId
            )
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#unpin-message
     *
     * @return PromiseInterface<void>
     */
    public function unpinMessage(string $channelId, string $messageId): PromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::CHANNEL_PIN,
                $channelId,
                $messageId
            )
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#start-thread-from-message
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Channel>
     */
    public function startThreadFromMessage(
        string $channelId,
        string $messageId,
        StartThreadFromMessageBuilder $startThreadFromMessageBuilder
    ): PromiseInterface {
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
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#start-thread-without-message
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Channel>
     */
    public function startThreadWithoutMessage(
        string $channelId,
        StartThreadWithoutMessageBuilder $startThreadWithoutMessageBuilder
    ): PromiseInterface {
        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(
                    Endpoint::CHANNEL_THREADS,
                    $channelId
                ),
                $startThreadWithoutMessageBuilder->get()
            ),
            PartsChannel::class
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#start-thread-in-forum-or-media-channel
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Channel> includes $message property
     */
    public function startThreadInForumChannel(
        string $channelId,
        MultipartBody|array $params,
        ?string $reason = null
    ): PromiseInterface {
        $forumChannelWithMessage = new class() extends Channel {
            public Message $message;
        };

        return $this->mapPromise(
            $this->http->post(
                Endpoint::bind(Endpoint::CHANNEL_THREADS, $channelId),
                $params,
                $this->getAuditLogReasonHeader($reason),
            ),
            $forumChannelWithMessage::class,
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#join-thread
     *
     * @return PromiseInterface<void>
     */
    public function joinThread(string $channelId): PromiseInterface
    {
        return $this->http->put(
            Endpoint::bind(
                Endpoint::THREAD_MEMBER_ME,
                $channelId
            )
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#add-thread-member
     *
     * @return PromiseInterface<void>
     */
    public function addThreadMember(string $channelId, string $userId): PromiseInterface
    {
        return $this->http->put(
            Endpoint::bind(
                Endpoint::THREAD_MEMBER,
                $channelId,
                $userId
            )
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#leave-thread
     *
     * @return PromiseInterface<void>
     */
    public function leaveThread(string $channelId): PromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::THREAD_MEMBER_ME,
                $channelId
            )
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#remove-thread-member
     *
     * @return PromiseInterface<void>
     */
    public function removeThreadMember(string $channelId, string $userId): PromiseInterface
    {
        return $this->http->delete(
            Endpoint::bind(
                Endpoint::THREAD_MEMBER,
                $channelId,
                $userId
            )
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#get-thread-member
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ThreadMember>
     */
    public function getThreadMember(string $channelId, string $userId): PromiseInterface
    {
        return $this->mapPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::THREAD_MEMBER,
                    $channelId,
                    $userId
                )
            ),
            ThreadMember::class
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#list-thread-members
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\ThreadMember[]>
     */
    public function listThreadMembers(
        string $channelId,
        ?bool $withMember = null,
        ?string $after = null,
        ?int $limit = null,
    ): PromiseInterface {
        $options = array_filter([
            'with_member' => $withMember,
            'after' => $after,
            'limit' => $limit,
        ], static fn($value) => !is_null($value));

        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::THREAD_MEMBERS,
                    $channelId
                ),
                $options
            ),
            ThreadMember::class
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#list-public-archived-threads
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Channel[]>
     */
    public function listPublicArchivedThreads(string $channelId): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::CHANNEL_THREADS_ARCHIVED_PUBLIC,
                    $channelId
                )
            ),
            PartsChannel::class
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#list-private-archived-threads
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Channel[]>
     */
    public function listPrivateArchivedThreads(string $channelId): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::CHANNEL_THREADS_ARCHIVED_PRIVATE,
                    $channelId
                )
            ),
            PartsChannel::class
        )->catch($this->logThrowable(...));
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#list-joined-private-archived-threads
     *
     * @return PromiseInterface<\Ragnarok\Fenrir\Parts\Channel[]>
     */
    public function listJoinedPrivateArchivedThreads(string $channelId): PromiseInterface
    {
        return $this->mapArrayPromise(
            $this->http->get(
                Endpoint::bind(
                    Endpoint::CHANNEL_THREADS_ARCHIVED_PRIVATE_ME,
                    $channelId
                )
            ),
            PartsChannel::class
        )->catch($this->logThrowable(...));
    }
}
