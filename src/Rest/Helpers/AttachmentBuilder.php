<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest\Helpers;

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

    public function setFilename(string $filename): AttachmentBuilder
    {
        $this->data['filename'] = $filename;

        return $this;
    }

    public function setDescription(string $description): AttachmentBuilder
    {
        $this->data['description'] = $description;

        return $this;
    }

    public function setContentType(string $contentType): AttachmentBuilder
    {
        $this->data['content_type'] = $contentType;

        return $this;
    }

    public function setSize(int $size): AttachmentBuilder
    {
        $this->data['size'] = $size;

        return $this;
    }

    public function setUrl(string $url): AttachmentBuilder
    {
        $this->data['url'] = $url;

        return $this;
    }

    public function setProxyUrl(string $proxyUrl): AttachmentBuilder
    {
        $this->data['proxy_url'] = $proxyUrl;

        return $this;
    }

    public function setHeight(int $height): AttachmentBuilder
    {
        $this->data['height'] = $height;

        return $this;
    }

    public function setWidth(int $width): AttachmentBuilder
    {
        $this->data['width'] = $width;

        return $this;
    }

    public function setEphemeral(bool $ephemeral): AttachmentBuilder
    {
        $this->data['ephemeral'] = $ephemeral;

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
