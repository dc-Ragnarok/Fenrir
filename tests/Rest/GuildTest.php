<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest;

use Ragnarok\Fenrir\Parts\Channel;
use Ragnarok\Fenrir\Parts\Guild as PartsGuild;
use Ragnarok\Fenrir\Parts\GuildBan;
use Ragnarok\Fenrir\Parts\GuildMember;
use Ragnarok\Fenrir\Parts\GuildPreview;
use Ragnarok\Fenrir\Parts\WelcomeScreen;
use Ragnarok\Fenrir\Parts\BulkBanResult;
use Ragnarok\Fenrir\Parts\GuildOnboarding;
use Ragnarok\Fenrir\Rest\Helpers\Guild\ModifyGuildOnboardingBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Guild\ModifyWelcomeScreenBuilder;
use Ragnarok\Fenrir\Rest\Guild;
use Ragnarok\Fenrir\Rest\Helpers\Guild\ModifyChannelPositionsBuilder;
use Tests\Ragnarok\Fenrir\Rest\HttpHelperTestCase;

class GuildTest extends HttpHelperTestCase
{
    protected string $httpItemClass = Guild::class;

    public static function httpBindingsProvider(): array
    {
        return [
            'Modify welcome screen' => [
                'method' => 'modifyWelcomeScreen',
                'args' => ['::guild id::', ModifyWelcomeScreenBuilder::new()],
                'mockOptions' => [
                    'method' => 'patch',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => WelcomeScreen::class,
                ],
            ],
            'Get onboarding' => [
                'method' => 'getOnboarding',
                'args' => ['::guild id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => GuildOnboarding::class,
                ],
            ],
            'Modify onboarding' => [
                'method' => 'modifyOnboarding',
                'args' => ['::guild id::', ModifyGuildOnboardingBuilder::new()],
                'mockOptions' => [
                    'method' => 'put',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => GuildOnboarding::class,
                ],
            ],
            'Bulk ban' => [
                'method' => 'bulkBan',
                'args' => ['::guild id::', ['::user a::', '::user b::'], 3600],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => BulkBanResult::class,
                ],
            ],
            'Get role member counts' => [
                'method' => 'getRoleMemberCounts',
                'args' => ['::guild id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [],
            ],
            'Get guild' => [
                'method' => 'get',
                'args' => ['::guild id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsGuild::class,
                ]
            ],
            'Get guild with counts' => [
                'method' => 'get',
                'args' => ['::guild id::', true],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsGuild::class,
                ]
            ],
            'Get preview' => [
                'method' => 'getPreview',
                'args' => ['::guild id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => GuildPreview::class,
                ]
            ],
            'Delete guild' => [
                'method' => 'delete',
                'args' => ['::guild id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => [
                ]
            ],
            'Get channels' => [
                'method' => 'getChannels',
                'args' => ['::guild id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) [], (object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => Channel::class,
                    'array' => true,
                ]
            ],
            'Modify channel position' => [
                'method' => 'modifyChannelPositions',
                'args' => [
                    '::guild id::',
                    [
                        ModifyChannelPositionsBuilder::new(),
                        ModifyChannelPositionsBuilder::new(),
                    ]
                ],
                'mockOptions' => [
                    'method' => 'patch',
                    'return' => null,
                ],
                'validationOptions' => [
                ]
            ],
            'Get member' => [
                'method' => 'getMember',
                'args' => ['::guild id::', '::member id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => GuildMember::class,
                ]
            ],
            'Add member role' => [
                'method' => 'addMemberRole',
                'args' => ['::guild id::', '::member id::', '::role id::'],
                'mockOptions' => [
                    'method' => 'put',
                    'return' => null,
                ],
                'validationOptions' => []
            ],
            'Remove member role' => [
                'method' => 'removeMemberRole',
                'args' => ['::guild id::', '::member id::', '::role id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => []
            ],
            'Get ban' => [
                'method' => 'getBan',
                'args' => ['::guild id::', '::member id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => GuildBan::class,
                ]
            ],
        ];
    }
}
