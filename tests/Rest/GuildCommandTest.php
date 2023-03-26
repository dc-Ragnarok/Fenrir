<?php

declare(strict_types=1);

namespace Exan\Fenrir;

use Exan\Fenrir\Parts\ApplicationCommand;
use Exan\Fenrir\Rest\GuildCommand;
use Exan\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Tests\Exan\Fenrir\Rest\HttpHelperTestCase;

class GuildCommandTest extends HttpHelperTestCase
{
    protected string $httpItemClass = GuildCommand::class;

    public function httpBindingsProvider(): array
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
