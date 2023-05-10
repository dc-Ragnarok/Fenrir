<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Carbon\Carbon;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/resources/channel#embed-object
 */
class EmbedBuilder
{
    use GetNew;

    private array $data;

    /**
     * @param string $title Up to 256 characters
     */
    public function setTitle(string $title): self
    {
        $this->data['title'] = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->data['title'] ?? null;
    }

    /**
     * @var string $description Up to 4096 characters
     */
    public function setDescription(string $description): self
    {
        $this->data['description'] = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->data['description'] ?? null;
    }

    public function setUrl(string $url): self
    {
        $this->data['url'] = $url;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->data['url'] ?? null;
    }

    public function setTimestamp(Carbon $timestamp): self
    {
        $this->data['timestamp'] = $timestamp->toIso8601String();

        return $this;
    }

    public function getTimestamp(): ?Carbon
    {
        return isset($this->data['timestamp']) ? new Carbon($this->data['timestamp']) : null;
    }

    public function setColor(int $color): self
    {
        $this->data['color'] = $color;

        return $this;
    }

    public function getColor(): ?int
    {
        return $this->data['color'] ?? null;
    }

    public function setColour(int $color): self
    {
        return $this->setColor($color);
    }

    public function getColour(): ?int
    {
        return $this->getColor();
    }

    /**
     * @var string $text Up to 2048 characters
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-footer-structure
     */
    public function setFooter(string $text, ?string $iconUrl = null, ?string $proxyIconUrl = null): self
    {
        $this->data['footer'] = ['text' => $text];

        if (!is_null($iconUrl)) {
            $this->data['footer']['icon_url'] = $iconUrl;
        }

        if (!is_null($proxyIconUrl)) {
            $this->data['footer']['proxy_icon_url'] = $proxyIconUrl;
        }

        return $this;
    }

    public function getFooter(): ?array
    {
        return $this->data['footer'] ?? null;
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-image-structure
     */
    public function setImage(
        string $url,
        ?string $proxyUrl = null,
        ?int $height = null,
        ?int $width = null
    ): self {
        $this->data['image'] = ['url' => $url];

        if (!is_null($proxyUrl)) {
            $this->data['image']['proxy_url'] = $proxyUrl;
        }

        if (!is_null($height)) {
            $this->data['image']['height'] = $height;
        }

        if (!is_null($width)) {
            $this->data['image']['width'] = $width;
        }

        return $this;
    }

    public function getImage(): ?array
    {
        return $this->data['image'] ?? null;
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-thumbnail-structure
     */
    public function setThumbnail(
        string $url,
        ?string $proxyUrl = null,
        ?int $height = null,
        ?int $width = null
    ): self {
        $this->data['thumbnail'] = ['url' => $url];

        if (!is_null($proxyUrl)) {
            $this->data['thumbnail']['proxy_url'] = $proxyUrl;
        }

        if (!is_null($height)) {
            $this->data['thumbnail']['height'] = $height;
        }

        if (!is_null($width)) {
            $this->data['thumbnail']['width'] = $width;
        }

        return $this;
    }

    public function getThumbnail(): ?array
    {
        return $this->data['thumbnail'] ?? null;
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-video-structure
     */
    public function setVideo(
        string $url,
        ?string $proxyUrl = null,
        ?int $height = null,
        ?int $width = null
    ): self {
        $this->data['video'] = ['url' => $url];

        if (!is_null($proxyUrl)) {
            $this->data['video']['proxy_url'] = $proxyUrl;
        }

        if (!is_null($height)) {
            $this->data['video']['height'] = $height;
        }

        if (!is_null($width)) {
            $this->data['video']['width'] = $width;
        }

        return $this;
    }

    public function getVideo(): ?array
    {
        return $this->data['video'] ?? null;
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-provider-structure
     */
    public function setProvider(?string $name = null, ?string $url = null): self
    {
        if (!isset($this->data['provider'])) {
            $this->data['provider'] = [];
        }

        if (!is_null($name)) {
            $this->data['provider']['name'] = $name;
        }

        if (!is_null($url)) {
            $this->data['provider']['url'] = $url;
        }

        return $this;
    }

    public function getProvider(): ?array
    {
        return $this->data['provider'] ?? null;
    }

    /**
     * @var string $name Up to 256 characters
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-author-structure
     */
    public function setAuthor(
        string $name,
        ?string $url = null,
        ?string $iconUrl = null,
        ?string $proxyIconUrl = null
    ): self {
        $this->data['author'] = ['name' => $name];

        if (!is_null($url)) {
            $this->data['author']['url'] = $url;
        }

        if (!is_null($iconUrl)) {
            $this->data['author']['icon_url'] = $iconUrl;
        }

        if (!is_null($proxyIconUrl)) {
            $this->data['author']['proxy_icon_url'] = $proxyIconUrl;
        }

        return $this;
    }

    public function getAuthor(): ?array
    {
        return $this->data['author'] ?? null;
    }

    /**
     * @var string $name Up to 256 characters
     * @var string $value Up to 1024 characters
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-field-structure
     */
    public function addField(string $name, string $value, bool $inline = false): self
    {
        if (!isset($this->data['fields'])) {
            $this->data['fields'] = [];
        }

        $this->data['fields'][] = [
            'name' => $name,
            'value' => $value,
            'inline' => $inline
        ];

        return $this;
    }

    public function getFields(): ?array
    {
        return $this->data['fields'] ?? null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
