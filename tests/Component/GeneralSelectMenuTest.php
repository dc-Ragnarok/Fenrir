<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Component;

use Exan\Fenrir\Component\SelectMenu\MentionableSelectMenu;
use Exan\Fenrir\Component\SelectMenu\RoleSelectMenu;
use Exan\Fenrir\Component\SelectMenu\UserSelectMenu;
use Exan\Fenrir\Enums\Component\SelectMenuType;
use PHPUnit\Framework\TestCase;

class GeneralSelectMenuTest extends TestCase
{
    /**
     * @dataProvider convertionExpectationProvider
     */
    public function testCorrectlyConverted(array $args, array $expected)
    {
        $selectTypes = [
            MentionableSelectMenu::class => SelectMenuType::Mentionable,
            RoleSelectMenu::class => SelectMenuType::Role,
            UserSelectMenu::class => SelectMenuType::User,
        ];

        foreach ($selectTypes as $selectClass => $selectType) {
            $expected['type'] = $selectType;

            $select = new $selectClass(...$args);

            $this->assertEquals($expected, $select->get());
        }
    }

    public function convertionExpectationProvider(): array
    {
        return [
            'Completely filled out' => [
                'args' => [
                    '::custom id::',
                    '::placeholder::',
                    5,
                    10,
                    true
                ],
                'expected' => [
                    'custom_id' => '::custom id::',
                    'placeholder' => '::placeholder::',
                    'min_values' => 5,
                    'max_values' => 10,
                    'disabled' => true,
                ],
            ],
            'Missing placeholder' => [
                'args' => [
                    '::custom id::',
                    null,
                    5,
                    10,
                    true
                ],
                'expected' => [
                    'custom_id' => '::custom id::',
                    'min_values' => 5,
                    'max_values' => 10,
                    'disabled' => true,
                ],
            ],
            'Missing min values' => [
                'args' => [
                    '::custom id::',
                    '::placeholder::',
                    null,
                    10,
                    true
                ],
                'expected' => [
                    'custom_id' => '::custom id::',
                    'placeholder' => '::placeholder::',
                    'min_values' => 1,
                    'max_values' => 10,
                    'disabled' => true,
                ],
            ],
            'Missing max values' => [
                'args' => [
                    '::custom id::',
                    '::placeholder::',
                    5,
                    null,
                    true
                ],
                'expected' => [
                    'custom_id' => '::custom id::',
                    'placeholder' => '::placeholder::',
                    'min_values' => 5,
                    'max_values' => 25,
                    'disabled' => true,
                ],
            ],
            'Missing disabled' => [
                'args' => [
                    '::custom id::',
                    '::placeholder::',
                    5,
                    10,
                ],
                'expected' => [
                    'custom_id' => '::custom id::',
                    'placeholder' => '::placeholder::',
                    'min_values' => 5,
                    'max_values' => 10,
                    'disabled' => false,
                ],
            ],
        ];
    }
}
