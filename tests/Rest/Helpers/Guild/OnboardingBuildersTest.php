<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Guild;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Enums\GuildOnboardingMode;
use Ragnarok\Fenrir\Enums\OnboardingPromptType;
use Ragnarok\Fenrir\Exceptions\Component\TooManyItemsException;
use Ragnarok\Fenrir\Rest\Helpers\Guild\ModifyGuildOnboardingBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Guild\OnboardingPromptBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Guild\OnboardingPromptOptionBuilder;

class OnboardingBuildersTest extends TestCase
{
    public function testItBuildsAWholeOnboardingFlow(): void
    {
        $onboarding = ModifyGuildOnboardingBuilder::new()
            ->setEnabled(true)
            ->setMode(GuildOnboardingMode::ONBOARDING_ADVANCED)
            ->setDefaultChannelIds(['::general::'])
            ->addPrompt(
                OnboardingPromptBuilder::new()
                    ->setId('0')
                    ->setTitle('What brings you here?')
                    ->setType(OnboardingPromptType::MULTIPLE_CHOICE)
                    ->setSingleSelect(true)
                    ->setRequired(true)
                    ->setInOnboarding(true)
                    ->addOption(
                        OnboardingPromptOptionBuilder::new()
                            ->setId('0')
                            ->setTitle('Support')
                            ->setRoleIds(['::support role::'])
                            ->setChannelIds(['::help channel::'])
                    )
            );

        $this->assertEquals([
            'enabled' => true,
            'mode' => GuildOnboardingMode::ONBOARDING_ADVANCED->value,
            'default_channel_ids' => ['::general::'],
            'prompts' => [
                [
                    'id' => '0',
                    'title' => 'What brings you here?',
                    'type' => OnboardingPromptType::MULTIPLE_CHOICE->value,
                    'single_select' => true,
                    'required' => true,
                    'in_onboarding' => true,
                    'options' => [
                        [
                            'id' => '0',
                            'title' => 'Support',
                            'role_ids' => ['::support role::'],
                            'channel_ids' => ['::help channel::'],
                        ],
                    ],
                ],
            ],
        ], $onboarding->get());
    }

    /**
     * A prompt always carries an options key, even an empty one, because
     * Discord treats it as required.
     */
    public function testAPromptAlwaysSendsItsOptions(): void
    {
        $this->assertEquals(
            ['id' => '0', 'options' => []],
            OnboardingPromptBuilder::new()->setId('0')->get()
        );
    }

    public function testPromptsAreOmittedWhenNoneWereAdded(): void
    {
        $this->assertEquals(
            ['enabled' => false],
            ModifyGuildOnboardingBuilder::new()->setEnabled(false)->get()
        );
    }

    public function testItRejectsASixteenthPrompt(): void
    {
        $onboarding = ModifyGuildOnboardingBuilder::new();

        for ($i = 0; $i < ModifyGuildOnboardingBuilder::MAX_PROMPTS; $i++) {
            $onboarding->addPrompt(OnboardingPromptBuilder::new()->setId((string) $i));
        }

        $this->expectException(TooManyItemsException::class);

        $onboarding->addPrompt(OnboardingPromptBuilder::new()->setId('one too many'));
    }

    public function testAnOptionCanCarryAnEmoji(): void
    {
        $option = OnboardingPromptOptionBuilder::new()
            ->setTitle('Support')
            ->setEmoji(emojiName: '::emoji::');

        $this->assertEquals([
            'title' => 'Support',
            'emoji_id' => null,
            'emoji_name' => '::emoji::',
        ], $option->get());
    }
}
