<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Enums\SortingOrder;
use Ragnarok\Fenrir\Enums\ThreadSearchTagSetting;
use Ragnarok\Fenrir\Enums\ThreadSortingMode;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/resources/channel#search-threads
 */
class SearchThreadsBuilder
{
    use GetNew;

    private array $data = [];

    public function setName(string $name): self
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    /**
     * @var int $slop How much fuzziness to allow when matching the name, 0 to 100
     */
    public function setSlop(int $slop): self
    {
        $this->data['slop'] = $slop;

        return $this;
    }

    public function setMinId(string $minId): self
    {
        $this->data['min_id'] = $minId;

        return $this;
    }

    public function setMaxId(string $maxId): self
    {
        $this->data['max_id'] = $maxId;

        return $this;
    }

    /**
     * @param string[] $tags Forum tag ids
     */
    public function setTags(array $tags): self
    {
        $this->data['tag'] = array_values($tags);

        return $this;
    }

    /** @return ?string[] */
    public function getTags(): ?array
    {
        return $this->data['tag'] ?? null;
    }

    /**
     * Whether a thread has to carry every requested tag or just one of them.
     */
    public function setTagSetting(ThreadSearchTagSetting $tagSetting): self
    {
        $this->data['tag_setting'] = $tagSetting->value;

        return $this;
    }

    public function setArchived(bool $archived): self
    {
        $this->data['archived'] = $archived;

        return $this;
    }

    public function setSortBy(ThreadSortingMode $sortBy): self
    {
        $this->data['sort_by'] = $sortBy->value;

        return $this;
    }

    public function setSortOrder(SortingOrder $sortOrder): self
    {
        $this->data['sort_order'] = $sortOrder->value;

        return $this;
    }

    /**
     * @var int $limit Between 1 and 25
     */
    public function setLimit(int $limit): self
    {
        $this->data['limit'] = $limit;

        return $this;
    }

    public function setOffset(int $offset): self
    {
        $this->data['offset'] = $offset;

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
