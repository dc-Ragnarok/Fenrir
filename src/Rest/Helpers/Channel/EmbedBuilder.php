<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel;

use Carbon\Carbon;
use Exan\Fenrir\Rest\Helpers\GetNew;

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
    public function setTitle(string $title): EmbedBuilder
    {
        $this->data['title'] = $title;

        return $this;
    }

    /**
     * @deprecated
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-types
     */
    public function setType(string $type): EmbedBuilder
    {
        $this->data['type'] = $type;

        return $this;
    }

    /**
     * @var string $description Up to 4096 characters
     */
    public function setDescription(string $description): EmbedBuilder
    {
        $this->data['description'] = $description;

        return $this;
    }

    public function setUrl(string $url): EmbedBuilder
    {
        $this->data['url'] = $url;

        return $this;
    }

    public function setTimestamp(Carbon $timestamp): EmbedBuilder
    {
        $this->data['timestamp'] = $timestamp->toIso8601String();

        return $this;
    }

    public function setColor(int $color): EmbedBuilder
    {
        $this->data['color'] = $color;

        return $this;
    }

    public function setColour(int $color): EmbedBuilder
    {
        return $this->setColor($color);
    }

    /**
     * @var string $text Up to 2048 characters
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-footer-structure
     */
    public function setFooter(string $text, ?string $iconUrl = null, ?string $proxyIconUrl = null): EmbedBuilder
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

    /**
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-image-structure
     */
    public function setImage(
        string $url,
        ?string $proxyUrl = null,
        ?int $height = null,
        ?int $width = null
    ): EmbedBuilder {
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

    /**
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-thumbnail-structure
     */
    public function setThumbnail(
        string $url,
        ?string $proxyUrl = null,
        ?int $height = null,
        ?int $width = null
    ): EmbedBuilder {
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

    /**
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-video-structure
     */
    public function setVideo(
        string $url,
        ?string $proxyUrl = null,
        ?int $height = null,
        ?int $width = null
    ): EmbedBuilder {
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

    /**
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-provider-structure
     */
    public function setProvider(?string $name = null, ?string $url = null): EmbedBuilder
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

    /**
     * @var string $name Up to 256 characters
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-author-structure
     */
    public function setAuthor(
        string $name,
        ?string $url = null,
        ?string $iconUrl = null,
        ?string $proxyIconUrl = null
    ): EmbedBuilder {
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

    /**
     * @var string $name Up to 256 characters
     * @var string $value Up to 1024 characters
     * @see https://discord.com/developers/docs/resources/channel#embed-object-embed-field-structure
     */
    public function addField(string $name, string $value, bool $inline = false): EmbedBuilder
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

    public function get(): array
    {
        return $this->data;
    }
}
