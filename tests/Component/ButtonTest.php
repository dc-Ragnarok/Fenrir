<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Component;

use Ragnarok\Fenrir\Component\Button\DangerButton;
use Ragnarok\Fenrir\Component\Button\LinkButton;
use Ragnarok\Fenrir\Component\Button\PrimaryButton;
use Ragnarok\Fenrir\Component\Button\SecondaryButton;
use Ragnarok\Fenrir\Component\Button\SuccessButton;
use Ragnarok\Fenrir\Enums\Component\ButtonStyle;
use Ragnarok\Fenrir\Parts\Emoji;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\EmojiBuilder;
use PHPUnit\Framework\TestCase;

class ButtonTest extends TestCase
{
    private function getEmoji(): EmojiBuilder
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
    public function testCorrectlyConverted(array $args, array $expected)
    {
        $buttonTypes = [
            DangerButton::class => ButtonStyle::Danger,
            PrimaryButton::class => ButtonStyle::Primary,
            SecondaryButton::class => ButtonStyle::Secondary,
            SuccessButton::class => ButtonStyle::Success,
        ];

        foreach ($buttonTypes as $buttonClass => $buttonStyle) {
            $expected['style'] = $buttonStyle;

            $button = new $buttonClass(...$args);

            $this->assertEquals($expected, $button->get());
        }
    }

    public function convertionExpectationProvider(): array
    {
        return [
            'Completely filled out' => [
                'args' => [
                    '::custom id::',
                    '::label::',
                    $this->getEmoji(),
                    true,
                ],
                'expected' => [
                    'type' => 2,
                    'custom_id' => '::custom id::',
                    'label' => '::label::',
                    'emoji' => $this->getEmoji()->get(),
                    'disabled' => true
                ],
            ],
            'Missing label' => [
                'args' => [
                    '::custom id::',
                    null,
                    $this->getEmoji(),
                    true,
                ],
                'expected' => [
                    'type' => 2,
                    'custom_id' => '::custom id::',
                    'emoji' => $this->getEmoji()->get(),
                    'disabled' => true
                ],
            ],
            'Missing emoji' => [
                'args' => [
                    '::custom id::',
                    '::label::',
                    null,
                    true,
                ],
                'expected' => [
                    'type' => 2,
                    'custom_id' => '::custom id::',
                    'label' => '::label::',
                    'disabled' => true
                ],
            ],
            'Missing disabled' => [
                'args' => [
                    '::custom id::',
                    '::label::',
                    $this->getEmoji(),
                ],
                'expected' => [
                    'type' => 2,
                    'custom_id' => '::custom id::',
                    'label' => '::label::',
                    'emoji' => $this->getEmoji()->get(),
                    'disabled' => false
                ],
            ],
        ];
    }

    /**
     * @dataProvider convertionExpectationProviderLinkButton
     */
    public function testCorrectlyConvertedLinkButton(array $args, array $expected)
    {
        $button = new LinkButton(...$args);

        $this->assertEquals($expected, $button->get());
    }

    public function convertionExpectationProviderLinkButton(): array
    {
        return [
            'Completely filled out' => [
                'args' => [
                    '::url::',
                    '::label::',
                    $this->getEmoji(),
                    true,
                ],
                'expected' => [
                    'type' => 2,
                    'style' => ButtonStyle::Link,
                    'url' => '::url::',
                    'label' => '::label::',
                    'emoji' => $this->getEmoji()->get(),
                    'disabled' => true
                ],
            ],
            'Missing label' => [
                'args' => [
                    '::url::',
                    null,
                    $this->getEmoji(),
                    true,
                ],
                'expected' => [
                    'type' => 2,
                    'style' => ButtonStyle::Link,
                    'url' => '::url::',
                    'emoji' => $this->getEmoji()->get(),
                    'disabled' => true
                ],
            ],
            'Missing emoji' => [
                'args' => [
                    '::url::',
                    '::label::',
                    null,
                    true,
                ],
                'expected' => [
                    'type' => 2,
                    'style' => ButtonStyle::Link,
                    'url' => '::url::',
                    'label' => '::label::',
                    'disabled' => true
                ],
            ],
            'Missing disabled' => [
                'args' => [
                    '::url::',
                    '::label::',
                    $this->getEmoji(),
                ],
                'expected' => [
                    'type' => 2,
                    'style' => ButtonStyle::Link,
                    'url' => '::url::',
                    'label' => '::label::',
                    'emoji' => $this->getEmoji()->get(),
                    'disabled' => false
                ],
            ],
        ];
    }
}
