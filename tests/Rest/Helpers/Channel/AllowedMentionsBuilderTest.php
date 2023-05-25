<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Rest\Helpers\Channel\AllowedMentionsBuilder;
use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Enums\AllowedMentionType;
use Ragnarok\Fenrir\Exceptions\Rest\EagerDiscordValidationException;

class AllowedMentionsBuilderTest extends TestCase
{
    protected function getBuilder(): string
    {
        return AllowedMentionsBuilder::class;
    }

    /**
     * @dataProvider happyBuilderProvider
     */
    public function testHappyBuilder(array $args, array $expected)
    {
        $this->assertEquals(
            $expected,
            (new ($this->getBuilder())(...$args))->get()
        );
    }

    public function happyBuilderProvider(): array
    {
        return [
            'Users + roles' => [
                'args' => [
                    'roles' => ['::role 1::', '::role 2::'],
                    'users' => ['::user 1::', '::user 2::'],
                ],
                'expected' => [
                    'parse' => [AllowedMentionType::ROLES->value, AllowedMentionType::USERS->value],
                    'roles' => ['::role 1::', '::role 2::'],
                    'users' => ['::user 1::', '::user 2::'],
                ]
            ],
            'Empty users + empty roles' => [
                'args' => [
                    'roles' => [],
                    'users' => [],
                ],
                'expected' => [
                    'parse' => [AllowedMentionType::ROLES->value, AllowedMentionType::USERS->value],
                    'roles' => [],
                    'users' => [],
                ]
            ],
            'Users + everyone' => [
                'args' => [
                    'users' => ['::user 1::', '::user 2::'],
                    'everyone' => true,
                ],
                'expected' => [
                    'parse' => [
                        AllowedMentionType::USERS->value,
                        AllowedMentionType::EVERYONE->value
                    ],
                    'users' => ['::user 1::', '::user 2::'],
                ]
            ],
            'Replied user + everyone' => [
                'args' => [
                    'replied_user' => true,
                    'everyone' => true,
                ],
                'expected' => [
                    'parse' => [
                        AllowedMentionType::EVERYONE->value
                    ],
                    'replied_user' => true,
                ]
            ],
        ];
    }

    /**
     * @dataProvider errorBuilderProvider
     */
    public function testErrorBuilder(array $args)
    {
        $this->expectException(EagerDiscordValidationException::class);

        new ($this->getBuilder())(...$args);
    }

    public function errorBuilderProvider(): array
    {
        return [
            'Too many users' => [
                'args' => [
                    'users' => array_map(fn (int $i) => (string) $i, range(1, 101)),
                ]
            ],
            'Too many roles' => [
                'args' => [
                    'roles' => array_map(fn (int $i) => (string) $i, range(1, 101)),
                ]
            ],
        ];
    }
}
