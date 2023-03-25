<?php

declare(strict_types=1);

namespace Exan\Fenrir;

use Exan\Fenrir\Parts\ApplicationCommand;
use Exan\Fenrir\Rest\GlobalCommand;
use Exan\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Tests\Exan\Fenrir\Rest\HttpHelperTestCase;

class GlobalCommandTest extends HttpHelperTestCase
{
    protected string $httpItemClass = GlobalCommand::class;

    public function httpBindingsProvider(): array
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
