<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Enums\PollLayoutType;
use Ragnarok\Fenrir\Exceptions\Rest\Helpers\PollBuilder\TooManyAnswersException;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/resources/poll#poll-create-request-object
 */
class PollBuilder
{
    use GetNew;

    public const MAX_ANSWERS = 10;

    private array $data = [];

    /**
     * Discord only renders the text of a poll question, so an emoji on the
     * question is silently dropped.
     */
    public function setQuestion(string $text): self
    {
        $this->data['question'] = ['text' => $text];

        return $this;
    }

    public function getQuestion(): ?array
    {
        return $this->data['question'] ?? null;
    }

    /**
     * @throws TooManyAnswersException
     */
    public function addAnswer(string $text, ?string $emojiName = null, ?string $emojiId = null): self
    {
        if (count($this->data['answers'] ?? []) >= self::MAX_ANSWERS) {
            throw new TooManyAnswersException('A poll can have at most ' . self::MAX_ANSWERS . ' answers');
        }

        $pollMedia = ['text' => $text];

        if (!is_null($emojiName)) {
            $pollMedia['emoji'] = ['name' => $emojiName];
        }

        if (!is_null($emojiId)) {
            $pollMedia['emoji'] = ['id' => $emojiId];
        }

        $this->data['answers'][] = ['poll_media' => $pollMedia];

        return $this;
    }

    public function getAnswers(): ?array
    {
        return $this->data['answers'] ?? null;
    }

    /**
     * @var int $duration Hours the poll stays open for, up to 32 days
     */
    public function setDuration(int $duration): self
    {
        $this->data['duration'] = $duration;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->data['duration'] ?? null;
    }

    public function setAllowMultiselect(bool $allowMultiselect): self
    {
        $this->data['allow_multiselect'] = $allowMultiselect;

        return $this;
    }

    public function getAllowMultiselect(): ?bool
    {
        return $this->data['allow_multiselect'] ?? null;
    }

    public function setLayoutType(PollLayoutType $layoutType): self
    {
        $this->data['layout_type'] = $layoutType->value;

        return $this;
    }

    public function getLayoutType(): ?PollLayoutType
    {
        return isset($this->data['layout_type'])
            ? PollLayoutType::from($this->data['layout_type'])
            : null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
