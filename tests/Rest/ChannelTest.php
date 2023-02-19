<?php

declare(strict_types=1);

namespace Tests\Exan\Dhp\Rest;

use Exan\Dhp\Parts\Channel as PartsChannel;
use Exan\Dhp\Parts\Emoji;
use Exan\Dhp\Parts\Invite;
use Exan\Dhp\Parts\Message;
use Exan\Dhp\Parts\ThreadMember;
use Exan\Dhp\Parts\User;
use Exan\Dhp\Rest\Channel;
use Exan\Dhp\Rest\Helpers\Channel\Channel\GuildAnnouncementChannelBuilder;
use Exan\Dhp\Rest\Helpers\Channel\Channel\GuildForumChannelBuilder;
use Exan\Dhp\Rest\Helpers\Channel\Channel\GuildStageVoiceChannelBuilder;
use Exan\Dhp\Rest\Helpers\Channel\Channel\GuildTextChannelBuilder;
use Exan\Dhp\Rest\Helpers\Channel\Channel\GuildVoiceChannelBuilder;
use Exan\Dhp\Rest\Helpers\Channel\EditMessageBuilder;
use Exan\Dhp\Rest\Helpers\Channel\MessageBuilder;
use Exan\Dhp\Rest\Helpers\Channel\StartThreadFromMessageBuilder;
use Exan\Dhp\Rest\Helpers\Channel\StartThreadWithoutMessageBuilder;
use Exan\Dhp\Rest\Helpers\Emoji\EmojiBuilder;
use Tests\Exan\Dhp\Rest\HttpHelperTestCase;

class ChannelTest extends HttpHelperTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->httpItem = new Channel($this->http, $this->jsonMapper);
    }

    public function httpBindingsProvider(): array
    {
        return [
            'Get channel' => [
                'method' => 'get',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsChannel::class,
                ]
            ],
            'Modify channel with Guild Text' => [
                'method' => 'modify',
                'args' => ['::channel id::', new GuildTextChannelBuilder()],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsChannel::class,
                ]
            ],
            'Modify channel with Guild Announcement' => [
                'method' => 'modify',
                'args' => ['::channel id::', new GuildAnnouncementChannelBuilder()],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsChannel::class,
                ]
            ],
            'Modify channel with Guild Stage Voice' => [
                'method' => 'modify',
                'args' => ['::channel id::', new GuildStageVoiceChannelBuilder()],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsChannel::class,
                ]
            ],
            'Modify channel with Guild Forum' => [
                'method' => 'modify',
                'args' => ['::channel id::', new GuildForumChannelBuilder()],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsChannel::class,
                ]
            ],
            'Modify channel with Guild Voice' => [
                'method' => 'modify',
                'args' => ['::channel id::', new GuildVoiceChannelBuilder()],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsChannel::class,
                ]
            ],
            'Delete channel' => [
                'method' => 'delete',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsChannel::class,
                ]
            ],
            'Get messages' => [
                'method' => 'getMessages',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) [], (object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => Message::class,
                    'array' => true,
                ]
            ],
            'Get message' => [
                'method' => 'getMessage',
                'args' => ['::channel id::', '::message id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => Message::class,
                ]
            ],
            'Create message' => [
                'method' => 'createMessage',
                'args' => ['::channel id::', new MessageBuilder()],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => Message::class,
                ]
            ],
            'Create message with file' => [
                'method' => 'createMessage',
                'args' => ['::channel id::', (new MessageBuilder())->addFile('something.png', '::data::')],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => Message::class,
                ]
            ],
            'Crosspost message' => [
                'method' => 'crosspostMessage',
                'args' => ['::channel id::', '::message id::'],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => Message::class,
                ]
            ],
            'Create reaction' => [
                'method' => 'createReaction',
                'args' => ['::channel id::', '::message id::', (new EmojiBuilder())->setId('::id::')],
                'mockOptions' => [
                    'method' => 'put',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            'Delete own reaction' => [
                'method' => 'deleteOwnReaction',
                'args' => ['::channel id::', '::message id::', (new EmojiBuilder())->setId('::id::')],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            'Delete user reaction' => [
                'method' => 'deleteUserReaction',
                'args' => ['::channel id::', '::message id::', (new EmojiBuilder())->setId('::id::'), '::user id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            'Get reactions' => [
                'method' => 'getReactions',
                'args' => ['::channel id::', '::message id::', (new EmojiBuilder())->setId('::id::')],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) [], (object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => User::class,
                    'array' => true,
                ]
            ],
            'Delete all reactions' => [
                'method' => 'deleteAllReactions',
                'args' => ['::channel id::', '::message id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            'Delete all reactions for emoji' => [
                'method' => 'deleteAllReactionsForEmoji',
                'args' => ['::channel id::', '::message id::', (new EmojiBuilder())->setId('::id::')],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            'Edit message' => [
                'method' => 'editMessage',
                'args' => ['::channel id::', '::message id::', new EditMessageBuilder()],
                'mockOptions' => [
                    'method' => 'patch',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => Message::class,
                ]
            ],
            'Edit message with file' => [
                'method' => 'editMessage',
                'args' => [
                    '::channel id::',
                    '::message id::',
                    (new EditMessageBuilder())->addFile('something.png', '::data::')
                ],
                'mockOptions' => [
                    'method' => 'patch',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => Message::class,
                ]
            ],
            'Bulk delete messages' => [
                'method' => 'bulkDeleteMessages',
                'args' => ['::channel id::', ['::message id::'], (new EmojiBuilder())->setId('::id::')],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            /**
             * @todo editChannelPermissions
             */
            'Get channel invites' => [
                'method' => 'getChannelInvites',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) [], (object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => Invite::class,
                    'array' => true,
                ]
            ],
            'Create channel invite' => [
                'method' => 'createChannelInvite',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => Invite::class,
                ]
            ],
            'Delete channel permissions' => [
                'method' => 'deleteChannelPermissions',
                'args' => ['::channel id::', '::overwrite id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            /**
             * @todo followAnnouncementChannel
             */
            'Trigger typing indicator' => [
                'method' => 'triggerTypingIndicator',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            'Get pinned messages' => [
                'method' => 'getPinnedMessages',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) [], (object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => Message::class,
                    'array' => true,
                ],
            ],
            'Pin message' => [
                'method' => 'pinMessage',
                'args' => ['::channel id::', '::message id::'],
                'mockOptions' => [
                    'method' => 'put',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            'Unpin message' => [
                'method' => 'unpinMessage',
                'args' => ['::channel id::', '::message id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            'Start thread from message' => [
                'method' => 'startThreadFromMessage',
                'args' => ['::channel id::', '::message id::', new StartThreadFromMessageBuilder()],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsChannel::class,
                ],
            ],
            'Start thread without message' => [
                'method' => 'startThreadWithoutMessage',
                'args' => ['::channel id::', new StartThreadWithoutMessageBuilder()],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsChannel::class,
                ],
            ],
            'Join thread' => [
                'method' => 'joinThread',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'put',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            'Add thread member' => [
                'method' => 'addThreadMember',
                'args' => ['::channel id::', '::user id::'],
                'mockOptions' => [
                    'method' => 'put',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            'Leave thread' => [
                'method' => 'leaveThread',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            'Remove thread member' => [
                'method' => 'removeThreadMember',
                'args' => ['::channel id::', '::user id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            'Get thread member' => [
                'method' => 'getThreadMember',
                'args' => ['::channel id::', '::user id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => ThreadMember::class,
                ],
            ],
            'Get thread members' => [
                'method' => 'listThreadMembers',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) [], (object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => ThreadMember::class,
                    'array' => true
                ],
            ],
            'Get thread members' => [
                'method' => 'listThreadMembers',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) [], (object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => ThreadMember::class,
                    'array' => true
                ],
            ],
            'List public archived threads' => [
                'method' => 'listPublicArchivedThreads',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) [], (object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => PartsChannel::class,
                    'array' => true
                ],
            ],
            'List private archived threads' => [
                'method' => 'listPrivateArchivedThreads',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) [], (object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => PartsChannel::class,
                    'array' => true
                ],
            ],
            'List joined private archived threads' => [
                'method' => 'listJoinedPrivateArchivedThreads',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) [], (object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => PartsChannel::class,
                    'array' => true
                ],
            ],
        ];
    }
}
