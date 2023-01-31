<?php

declare(strict_types=1);

namespace Tests\Exan\Dhp\Rest;

use Exan\Dhp\Parts\Emoji as PartsEmoji;
use Exan\Dhp\Rest\Emoji;
use Exan\Dhp\Rest\Helpers\Emoji\EmojiBuilder;
use Tests\Exan\Dhp\Rest\HttpHelperTestCase;

class EmojiTest extends HttpHelperTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->httpItem = new Emoji($this->http, $this->jsonMapper);
    }

    public function httpBindingsProvider(): array
    {
        return [
            'List guild emojis' => [
                'method' => 'listGuildEmojis',
                'args' => ['::guild id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsEmoji::class,
                    'array' => true,
                ]
            ],
            'Get guild emoji' => [
                'method' => 'getGuildEmoji',
                'args' => ['::guild id::', '::emoji id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsEmoji::class,
                ]
            ],
            'Create guild emoji' => [
                'method' => 'createGuildEmoji',
                'args' => ['::guild id::', new EmojiBuilder()],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsEmoji::class,
                ]
            ],
            'Modify guild emoji' => [
                'method' => 'modifyGuildEmoji',
                'args' => ['::guild id::', '::emoji id::', new EmojiBuilder()],
                'mockOptions' => [
                    'method' => 'patch',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsEmoji::class,
                ]
            ],
            'Delete guild emoji' => [
                'method' => 'deleteGuildEmoji',
                'args' => ['::guild id::', '::emoji id::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => []
            ],
        ];
    }
}
