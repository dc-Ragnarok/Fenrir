<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest;

use Discord\Http\Http;
use Exan\Fenrir\DataMapper;

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
    public function __construct(private Http $http, private DataMapper $dataMapper)
    {
        $this->auditLog = new AuditLog($this->http, $this->dataMapper);
        $this->channel = new Channel($this->http, $this->dataMapper);
        $this->emoji = new Emoji($this->http, $this->dataMapper);
        $this->guildAutoModeration = new GuildAutoModeration($this->http, $this->dataMapper);
        $this->guildScheduledEvent = new GuildScheduledEvent($this->http, $this->dataMapper);
        $this->guildSticker = new GuildSticker($this->http, $this->dataMapper);
        $this->guildTemplate = new GuildTemplate($this->http, $this->dataMapper);
        $this->invite = new Invite($this->http, $this->dataMapper);
        $this->sticker = new Sticker($this->http, $this->dataMapper);
        $this->guildCommand = new GuildCommand($this->http, $this->dataMapper);
        $this->globalCommand = new GlobalCommand($this->http, $this->dataMapper);
        $this->webhook = new Webhook($this->http, $this->dataMapper);
    }
}
