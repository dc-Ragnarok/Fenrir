<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Message;

use Exan\Fenrir\Rest\Helpers\Channel\AttachmentBuilder;

trait AddAttachment
{
    /**
     * @see https://discord.com/developers/docs/resources/channel#attachment-object
     */
    public function addAttachment(AttachmentBuilder $attachment): self
    {
        if (!isset($this->data['attachments'])) {
            $this->data['attachments'] = [];
        }

        $this->data['attachments'][] = $attachment->get();

        return $this;
    }
}
