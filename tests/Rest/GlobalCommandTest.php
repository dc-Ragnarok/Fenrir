<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest;

use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Rest\GlobalCommand;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use React\Promise\Promise;
use Tests\Ragnarok\Fenrir\Rest\HttpHelperTestCase;

use function React\Async\await;

class GlobalCommandTest extends HttpHelperTestCase
{
    protected string $httpItemClass = GlobalCommand::class;

    /**
     * Discord expects a bare list of command objects, so the builders have to be
     * unwrapped and the keys discarded on the way out.
     */
    public function testBulkOverwriteSendsAListOfCommandPayloads(): void
    {
        $sent = null;

        $this->http->shouldReceive('put')->andReturnUsing(
            static function ($endpoint, $payload) use (&$sent) {
                $sent = $payload;

                return new Promise(static function ($resolve) {
                    $resolve([]);
                });
            }
        )->once();

        await($this->httpItem->bulkOverwriteApplicationCommands('::application id::', [
            'ping' => CommandBuilder::new()->setName('ping'),
            'pong' => CommandBuilder::new()->setName('pong'),
        ]));

        $this->assertSame([0, 1], array_keys($sent));
        $this->assertSame('ping', $sent[0]['name']);
        $this->assertSame('pong', $sent[1]['name']);
    }

    public static function httpBindingsProvider(): array
    {
        return [
            'Get commands' => [
                'method' => 'getCommands',
                'args' => ['::application id::'],
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
                'args' => ['::application id::', '::command id::'],
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
                'args' => ['::application id::', '::command id::'],
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
        ];
    }
}
