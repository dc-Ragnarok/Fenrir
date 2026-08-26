<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest;

use Ragnarok\Fenrir\Enums\ApplicationCommandPermissionType;
use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Parts\ApplicationCommandPermissionObject;
use Ragnarok\Fenrir\Parts\ApplicationCommandPermissionStructure;
use Ragnarok\Fenrir\Rest\GuildCommand;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Tests\Ragnarok\Fenrir\Rest\HttpHelperTestCase;

class GuildCommandTest extends HttpHelperTestCase
{
    protected string $httpItemClass = GuildCommand::class;

    private static function permission(): ApplicationCommandPermissionStructure
    {
        $permission = new ApplicationCommandPermissionStructure();
        $permission->id = '::role id::';
        $permission->type = ApplicationCommandPermissionType::ROLE;
        $permission->permission = true;

        return $permission;
    }

    public static function httpBindingsProvider(): array
    {
        return [
            'Get commands' => [
                'method' => 'getCommands',
                'args' => ['::guild id::', '::application id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => [(object) []],
                ],
                'validationOptions' => [
                    'returnType' => ApplicationCommand::class,
                    'array' => true,
                ],
            ],
            'Create application command' => [
                'method' => 'createApplicationCommand',
                'args' => [
                    '::application id::',
                    '::guild id::',
                    CommandBuilder::new()
                ],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => ApplicationCommand::class
                ],
            ],
            'Get application command' => [
                'method' => 'getApplicationCommand',
                'args' => ['::application id::', '::guild id::', '::command id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => ApplicationCommand::class
                ],
            ],
            'Edit application command' => [
                'method' => 'editApplicationCommand',
                'args' => [
                    '::application id::',
                    '::guild id::',
                    '::command id::',
                    CommandBuilder::new()
                ],
                'mockOptions' => [
                    'method' => 'patch',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => ApplicationCommand::class
                ],
            ],
            'Delete application command' => [
                'method' => 'deleteApplicationCommand',
                'args' => ['::application id::', '::guild id::', '::command id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
            'Bulk overwrite application commands' => [
                'method' => 'bulkOverwriteApplicationCommands',
                'args' => [
                    '::application id::',
                    '::guild id::',
                    [CommandBuilder::new(), CommandBuilder::new()]
                ],
                'mockOptions' => [
                    'method' => 'put',
                    'return' => [(object) [], (object) []],
                ],
                'validationOptions' => [
                    'returnType' => ApplicationCommand::class,
                    'array' => true,
                ],
            ],
            'Get application command permissions' => [
                'method' => 'getApplicationCommandPermissions',
                'args' => ['::application id::', '::guild id::', '::command id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => ApplicationCommandPermissionObject::class
                ],
            ],
            'Edit application command permissions' => [
                'method' => 'editApplicationCommandPermissions',
                'args' => [
                    '::application id::',
                    '::guild id::',
                    '::command id::',
                    [self::permission()]
                ],
                'mockOptions' => [
                    'method' => 'put',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => ApplicationCommandPermissionObject::class
                ],
            ],
        ];
    }
}
