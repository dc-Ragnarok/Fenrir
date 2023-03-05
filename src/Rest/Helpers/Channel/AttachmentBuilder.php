<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel;

/**
 * @see https://discord.com/developers/docs/resources/channel#attachment-object
 */
class AttachmentBuilder
{
    private $data = [];

    public function setId(string $id): AttachmentBuilder
    {
        $this->data['id'] = $id;

        return $this;
    }

    public function getId(): ?string
    {
        return isset($this->data['id']) ? $this->data['id'] : null;
    }

    public function setFilename(string $filename): AttachmentBuilder
    {
        $this->data['filename'] = $filename;

        return $this;
    }

    public function getFilename(): ?string
    {
        return isset($this->data['filename']) ? $this->data['filename'] : null;
    }

    public function setDescription(string $description): AttachmentBuilder
    {
        $this->data['description'] = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return isset($this->data['description']) ? $this->data['description'] : null;
    }

    public function setContentType(string $contentType): AttachmentBuilder
    {
        $this->data['content_type'] = $contentType;

        return $this;
    }

    public function getContentType(): ?string
    {
        return isset($this->data['content_type']) ? $this->data['content_type'] : null;
    }

    public function setSize(int $size): AttachmentBuilder
    {
        $this->data['size'] = $size;

        return $this;
    }

    public function getSize(): ?int
    {
        return isset($this->data['size']) ? $this->data['size'] : null;
    }

    public function setUrl(string $url): AttachmentBuilder
    {
        $this->data['url'] = $url;

        return $this;
    }

    public function getUrl(): ?string
    {
        return isset($this->data['url']) ? $this->data['url'] : null;
    }

    public function setProxyUrl(string $proxyUrl): AttachmentBuilder
    {
        $this->data['proxy_url'] = $proxyUrl;

        return $this;
    }

    public function getProxyUrl(): ?string
    {
        return isset($this->data['proxy_url']) ? $this->data['proxy_url'] : null;
    }

    public function setHeight(int $height): AttachmentBuilder
    {
        $this->data['height'] = $height;

        return $this;
    }

    public function getHeight(): ?int
    {
        return isset($this->data['height']) ? $this->data['height'] : null;
    }

    public function setWidth(int $width): AttachmentBuilder
    {
        $this->data['width'] = $width;

        return $this;
    }

    public function getWidth(): ?int
    {
        return isset($this->data['width']) ? $this->data['width'] : null;
    }

    public function setEphemeral(bool $ephemeral): AttachmentBuilder
    {
        $this->data['ephemeral'] = $ephemeral;

        return $this;
    }

    public function getEphermal(): ?bool
    {
        return isset($this->data['ephermal']) ? $this->data['ephermal'] : null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
