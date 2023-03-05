<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Http;
use JsonMapper;

class Rest
{
    public AuditLog $auditLog;
    public Channel $channel;
    public Emoji $emoji;
    public GuildAutoModeration $guildAutoModeration;
    public GuildScheduledEvent $guildScheduledEvent;
    public GuildSticker $guildSticker;
    public GuildTemplate $guildTemplate;
    public Invite $invite;
    public Sticker $sticker;
    public GuildCommand $guildCommand;
    public GlobalCommand $globalCommand;
    public Webhook $webhook;

    /**
     * @todo add
     * - Application
     * - Application Role Connection Metadata
     * - Guild
     * - Stage Instance
     * - User
     */
    public function __construct(private Http $http, private JsonMapper $jsonMapper)
    {
        $this->auditLog = new AuditLog($this->http, $this->jsonMapper);
        $this->channel = new Channel($this->http, $this->jsonMapper);
        $this->emoji = new Emoji($this->http, $this->jsonMapper);
        $this->guildAutoModeration = new GuildAutoModeration($this->http, $this->jsonMapper);
        $this->guildScheduledEvent = new GuildScheduledEvent($this->http, $this->jsonMapper);
        $this->guildSticker = new GuildSticker($this->http, $this->jsonMapper);
        $this->guildTemplate = new GuildTemplate($this->http, $this->jsonMapper);
        $this->invite = new Invite($this->http, $this->jsonMapper);
        $this->sticker = new Sticker($this->http, $this->jsonMapper);
        $this->guildCommand = new GuildCommand($this->http, $this->jsonMapper);
        $this->globalCommand = new GlobalCommand($this->http, $this->jsonMapper);
        $this->webhook = new Webhook($this->http, $this->jsonMapper);
    }
}
