<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Component;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Component\SelectMenu\StringSelectMenu;
use Ragnarok\Fenrir\Enums\SelectMenuType;
use Ragnarok\Fenrir\Exceptions\Components\SelectMenu\StringSelectMenu\NoOptionsException;
use Ragnarok\Fenrir\Exceptions\Components\SelectMenu\StringSelectMenu\TooManyOptionsException;
use Ragnarok\Fenrir\Parts\Emoji;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\EmojiBuilder;

class StringSelectMenuTest extends TestCase
{
    private static function getEmoji(): EmojiBuilder
    {
        $emoji = new Emoji();
        $emoji->id = '::emoji id::';
        $emoji->name = '::emoji name::';
        $emoji->animated = true;

        return EmojiBuilder::fromPart($emoji);
    }

    /**
     * @dataProvider convertionExpectationProvider
     */
    public function testCorrectlyConverted(array $args, array $expected): void
    {
        $select = new StringSelectMenu(...$args);

        $select->addOption('::label::', '::value::');

        $this->assertEquals($expected, $select->get());
    }

    public static function convertionExpectationProvider(): array
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
                    'type' => SelectMenuType::String,
                    'custom_id' => '::custom id::',
                    'placeholder' => '::placeholder::',
                    'min_values' => 5,
                    'max_values' => 10,
                    'disabled' => true,
                    'options' => [[
                        'label' => '::label::',
                        'value' => '::value::',
                    ]]
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
                    'type' => SelectMenuType::String,
                    'custom_id' => '::custom id::',
                    'min_values' => 5,
                    'max_values' => 10,
                    'disabled' => true,
                    'options' => [[
                        'label' => '::label::',
                        'value' => '::value::',
                    ]]
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
                    'type' => SelectMenuType::String,
                    'custom_id' => '::custom id::',
                    'placeholder' => '::placeholder::',
                    'min_values' => 1,
                    'max_values' => 10,
                    'disabled' => true,
                    'options' => [[
                        'label' => '::label::',
                        'value' => '::value::',
                    ]]
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
                    'type' => SelectMenuType::String,
                    'custom_id' => '::custom id::',
                    'placeholder' => '::placeholder::',
                    'min_values' => 5,
                    'max_values' => 25,
                    'disabled' => true,
                    'options' => [[
                        'label' => '::label::',
                        'value' => '::value::',
                    ]]
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
                    'type' => SelectMenuType::String,
                    'custom_id' => '::custom id::',
                    'placeholder' => '::placeholder::',
                    'min_values' => 5,
                    'max_values' => 10,
                    'disabled' => false,
                    'options' => [[
                        'label' => '::label::',
                        'value' => '::value::',
                    ]]
                ],
            ],
        ];
    }

    public function testItThrowsAnExceptionWhenNoItemsAreSet(): void
    {
        $select = new StringSelectMenu('::custom id::');

        $this->expectException(NoOptionsException::class);
        $select->get();
    }

    public function testItThrowsAnExceptionWhenSettingToManyItems(): void
    {
        $select = new StringSelectMenu('::custom id::');

        foreach (range(1, 25) as $i) {
            $select->addOption(
                '::label ' . $i . '::',
                '::value ' . $i . '::'
            );
        }

        $this->expectException(TooManyOptionsException::class);
        $select->addOption(
            '::too many label::',
            '::too many value::'
        );
    }

    /**
     * @dataProvider optionConversionProvider
     */
    public function testOptionConversion($args, $expected): void
    {
        $select = new StringSelectMenu('::custom id::');

        $select->addOption(...$args);

        $this->assertEquals(
            $expected,
            $select->get()['options'][0]
        );
    }

    public static function optionConversionProvider(): array
    {
        return [
            'Completely filled' => [
                'args' => [
                    '::label::',
                    '::value::',
                    '::description::',
                    self::getEmoji(),
                    true,
                ],
                'expected' => [
                    'label' => '::label::',
                    'value' => '::value::',
                    'description' => '::description::',
                    'emoji' => self::getEmoji()->get(),
                    'default' => true,
                ],
            ],
            'Missing description' => [
                'args' => [
                    '::label::',
                    '::value::',
                    null,
                    self::getEmoji(),
                    true,
                ],
                'expected' => [
                    'label' => '::label::',
                    'value' => '::value::',
                    'emoji' => self::getEmoji()->get(),
                    'default' => true,
                ],
            ],
            'No emoji' => [
                'args' => [
                    '::label::',
                    '::value::',
                    '::description::',
                    null,
                    true,
                ],
                'expected' => [
                    'label' => '::label::',
                    'value' => '::value::',
                    'description' => '::description::',
                    'default' => true,
                ],
            ],
            'No default' => [
                'args' => [
                    '::label::',
                    '::value::',
                    '::description::',
                    self::getEmoji(),
                ],
                'expected' => [
                    'label' => '::label::',
                    'value' => '::value::',
                    'description' => '::description::',
                    'emoji' => self::getEmoji()->get(),
                ],
            ],
        ];
    }
}
