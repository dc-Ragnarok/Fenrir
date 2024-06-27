<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest;

use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Rest\GuildCommand;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Tests\Ragnarok\Fenrir\Rest\HttpHelperTestCase;

class GuildCommandTest extends HttpHelperTestCase
{
    protected string $httpItemClass = GuildCommand::class;

    public static function httpBindingsProvider(): array
    {
        return [
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
        ];
    }
}
