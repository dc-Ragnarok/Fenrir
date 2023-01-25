<?php

declare(strict_types=1);

namespace Tests\Exan\Dhp\Component;

use Exan\Dhp\Component\SelectMenu\ChannelSelectMenu;
use Exan\Dhp\Enums\Component\SelectMenuType;
use Exan\Dhp\Enums\Parts\ChannelType;
use PHPUnit\Framework\TestCase;

class ChannelSelectMenuTest extends TestCase
{
    /**
     * @dataProvider convertionExpectationProvider
     */
    public function testCorrectlyConverted(array $args, array $expected)
    {
        $select = new ChannelSelectMenu(...$args);

        $this->assertEquals($expected, $select->get());
    }

    public function convertionExpectationProvider(): array
    {
        return [
            'Completely filled out' => [
                'args' => [
                    '::custom id::',
                    '::placeholder::',
                    [ChannelType::ANNOUNCEMENT_THREAD, ChannelType::PUBLIC_THREAD],
                    5,
                    10,
                    true
                ],
                'expected' => [
                    'type' => SelectMenuType::Channel,
                    'custom_id' => '::custom id::',
                    'placeholder' => '::placeholder::',
                    'channel_types' => [ChannelType::ANNOUNCEMENT_THREAD, ChannelType::PUBLIC_THREAD],
                    'min_values' => 5,
                    'max_values' => 10,
                    'disabled' => true,
                ],
            ],
            'Missing placeholder' => [
                'args' => [
                    '::custom id::',
                    null,
                    [ChannelType::ANNOUNCEMENT_THREAD, ChannelType::PUBLIC_THREAD],
                    5,
                    10,
                    true
                ],
                'expected' => [
                    'type' => SelectMenuType::Channel,
                    'custom_id' => '::custom id::',
                    'channel_types' => [ChannelType::ANNOUNCEMENT_THREAD, ChannelType::PUBLIC_THREAD],
                    'min_values' => 5,
                    'max_values' => 10,
                    'disabled' => true,
                ],
            ],
            'Missing channel types' => [
                'args' => [
                    '::custom id::',
                    '::placeholder::',
                    null,
                    5,
                    10,
                    true
                ],
                'expected' => [
                    'type' => SelectMenuType::Channel,
                    'custom_id' => '::custom id::',
                    'placeholder' => '::placeholder::',
                    'min_values' => 5,
                    'max_values' => 10,
                    'disabled' => true,
                ],
            ],
            'Missing min values' => [
                'args' => [
                    '::custom id::',
                    '::placeholder::',
                    [ChannelType::ANNOUNCEMENT_THREAD, ChannelType::PUBLIC_THREAD],
                    null,
                    10,
                    true
                ],
                'expected' => [
                    'type' => SelectMenuType::Channel,
                    'custom_id' => '::custom id::',
                    'placeholder' => '::placeholder::',
                    'channel_types' => [ChannelType::ANNOUNCEMENT_THREAD, ChannelType::PUBLIC_THREAD],
                    'min_values' => 1,
                    'max_values' => 10,
                    'disabled' => true,
                ],
            ],
            'Missing max values' => [
                'args' => [
                    '::custom id::',
                    '::placeholder::',
                    [ChannelType::ANNOUNCEMENT_THREAD, ChannelType::PUBLIC_THREAD],
                    5,
                    null,
                    true
                ],
                'expected' => [
                    'type' => SelectMenuType::Channel,
                    'custom_id' => '::custom id::',
                    'placeholder' => '::placeholder::',
                    'channel_types' => [ChannelType::ANNOUNCEMENT_THREAD, ChannelType::PUBLIC_THREAD],
                    'min_values' => 5,
                    'max_values' => 25,
                    'disabled' => true,
                ],
            ],
            'Missing disabled' => [
                'args' => [
                    '::custom id::',
                    '::placeholder::',
                    [ChannelType::ANNOUNCEMENT_THREAD, ChannelType::PUBLIC_THREAD],
                    5,
                    10,
                ],
                'expected' => [
                    'type' => SelectMenuType::Channel,
                    'custom_id' => '::custom id::',
                    'placeholder' => '::placeholder::',
                    'channel_types' => [ChannelType::ANNOUNCEMENT_THREAD, ChannelType::PUBLIC_THREAD],
                    'min_values' => 5,
                    'max_values' => 10,
                    'disabled' => false,
                ],
            ],
        ];
    }
}
