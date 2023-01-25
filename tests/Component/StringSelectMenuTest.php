<?php

declare(strict_types=1);

namespace Tests\Exan\Dhp\Component;

use Exan\Dhp\Component\SelectMenu\StringSelectMenu;
use Exan\Dhp\Enums\Component\SelectMenuType;
use Exan\Dhp\Exceptions\Components\SelectMenu\StringSelectMenu\NoOptionsException;
use Exan\Dhp\Exceptions\Components\SelectMenu\StringSelectMenu\TooManyOptionsException;
use Exan\Dhp\Parts\Emoji;
use PHPUnit\Framework\TestCase;

class StringSelectMenuTest extends TestCase
{
    private function getEmoji(): Emoji
    {
        $emoji = new Emoji();
        $emoji->id = '::emoji id::';
        $emoji->name = '::emoji name::';
        $emoji->animated = true;

        return $emoji;
    }

    /**
     * @dataProvider convertionExpectationProvider
     */
    public function testCorrectlyConverted(array $args, array $expected)
    {
        $select = new StringSelectMenu(...$args);

        $select->addOption('::label::', '::value::');

        $this->assertEquals($expected, $select->get());
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

    public function testItThrowsAnExceptionWhenNoItemsAreSet()
    {
        $select = new StringSelectMenu('::custom id::');

        $this->expectException(NoOptionsException::class);
        $select->get();
    }

    public function testItThrowsAnExceptionWhenSettingToManyItems()
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
    public function testOptionConversion($args, $expected)
    {
        $select = new StringSelectMenu('::custom id::');

        $select->addOption(...$args);

        $this->assertEquals(
            $expected,
            $select->get()['options'][0]
        );
    }

    public function optionConversionProvider(): array
    {
        return [
            'Completely filled' => [
                'args' => [
                    '::label::',
                    '::value::',
                    '::description::',
                    $this->getEmoji(),
                    true,
                ],
                'expected' => [
                    'label' => '::label::',
                    'value' => '::value::',
                    'description' => '::description::',
                    'emoji' => $this->getEmoji()->getPartial(),
                    'default' => true,
                ],
            ],
            'Missing description' => [
                'args' => [
                    '::label::',
                    '::value::',
                    null,
                    $this->getEmoji(),
                    true,
                ],
                'expected' => [
                    'label' => '::label::',
                    'value' => '::value::',
                    'emoji' => $this->getEmoji()->getPartial(),
                    'default' => true,
                ],
            ],
            'Completely filled' => [
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
            'Completely filled' => [
                'args' => [
                    '::label::',
                    '::value::',
                    '::description::',
                    $this->getEmoji(),
                ],
                'expected' => [
                    'label' => '::label::',
                    'value' => '::value::',
                    'description' => '::description::',
                    'emoji' => $this->getEmoji()->getPartial(),
                ],
            ],
        ];
    }
}
