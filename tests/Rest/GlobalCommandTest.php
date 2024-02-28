<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Rest\GlobalCommand;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Tests\Ragnarok\Fenrir\Rest\HttpHelperTestCase;

class GlobalCommandTest extends HttpHelperTestCase
{
    protected string $httpItemClass = GlobalCommand::class;

    public static function httpBindingsProvider(): array
    {
        return [
            'Create application command' => [
                'method' => 'createApplicationCommand',
                'args' => [
                    '::application id::',
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
