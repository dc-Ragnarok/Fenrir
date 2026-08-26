<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Enums\PollLayoutType;
use Ragnarok\Fenrir\Exceptions\Rest\Helpers\PollBuilder\TooManyAnswersException;
use Ragnarok\Fenrir\Rest\Helpers\Channel\PollBuilder;

class PollBuilderTest extends TestCase
{
    public function testItBuildsAPollCreateRequest(): void
    {
        $poll = PollBuilder::new()
            ->setQuestion('Best language?')
            ->addAnswer('PHP')
            ->addAnswer('Rust', emojiName: '::emoji::')
            ->setDuration(48)
            ->setAllowMultiselect(true)
            ->setLayoutType(PollLayoutType::DEFAULT);

        $this->assertEquals([
            'question' => ['text' => 'Best language?'],
            'answers' => [
                ['poll_media' => ['text' => 'PHP']],
                ['poll_media' => ['text' => 'Rust', 'emoji' => ['name' => '::emoji::']]],
            ],
            'duration' => 48,
            'allow_multiselect' => true,
            'layout_type' => PollLayoutType::DEFAULT->value,
        ], $poll->get());
    }

    public function testACustomEmojiIsSentById(): void
    {
        $poll = PollBuilder::new()->addAnswer('PHP', emojiId: '::emoji id::');

        $this->assertEquals(
            [['poll_media' => ['text' => 'PHP', 'emoji' => ['id' => '::emoji id::']]]],
            $poll->getAnswers()
        );
    }

    public function testItRejectsMoreThanTenAnswers(): void
    {
        $poll = PollBuilder::new();

        for ($i = 0; $i < PollBuilder::MAX_ANSWERS; $i++) {
            $poll->addAnswer('answer ' . $i);
        }

        $this->expectException(TooManyAnswersException::class);

        $poll->addAnswer('one too many');
    }

    public function testGettersReturnNullWhenUnset(): void
    {
        $poll = PollBuilder::new();

        $this->assertNull($poll->getQuestion());
        $this->assertNull($poll->getAnswers());
        $this->assertNull($poll->getDuration());
        $this->assertNull($poll->getAllowMultiselect());
        $this->assertNull($poll->getLayoutType());
    }
}
