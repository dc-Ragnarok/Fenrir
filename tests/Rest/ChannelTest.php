<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest;

use Ragnarok\Fenrir\Parts\Channel as PartsChannel;
use Ragnarok\Fenrir\Parts\Invite;
use Ragnarok\Fenrir\Parts\Message;
use Ragnarok\Fenrir\Parts\ThreadMember;
use Ragnarok\Fenrir\Parts\User;
use Ragnarok\Fenrir\Rest\Channel;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\GuildAnnouncementChannelBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\GuildForumChannelBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\GuildStageVoiceChannelBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\GuildTextChannelBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\GuildVoiceChannelBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\EditMessageBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\EditPermissionsBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\MessageBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\StartThreadFromMessageBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\StartThreadWithoutMessageBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\EmojiBuilder;
use Tests\Ragnarok\Fenrir\Rest\HttpHelperTestCase;

class ChannelTest extends HttpHelperTestCase
{
    protected string $httpItemClass = Channel::class;

    public static function httpBindingsProvider(): array
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
            'Delete message' => [
                'method' => 'deleteMessage',
                'args' => ['::channel id::', '::message id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => [
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
            'Edit channel permissions' => [
                'method' => 'editChannelPermissions',
                'args' => ['::channel id::', EditPermissionsBuilder::new()->setMemberId('::member id::')],
                'mockOptions' => [
                    'method' => 'put',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
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
            'Follow announcement channel' => [
                'method' => 'followAnnouncementChannel',
                'args' => ['::channel id::', '::webhook channel id::'],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
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
