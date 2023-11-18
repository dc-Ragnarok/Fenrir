<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest;

use Discord\Http\Http;
use Psr\Log\LoggerInterface;
use Ragnarok\Fenrir\DataMapper;

class Rest
{
    public readonly Application $application;
    public readonly AuditLog $auditLog;
    public readonly Channel $channel;
    public readonly Emoji $emoji;
    public readonly GuildAutoModeration $guildAutoModeration;
    public readonly GuildScheduledEvent $guildScheduledEvent;
    public readonly GuildSticker $guildSticker;
    public readonly GuildTemplate $guildTemplate;
    public readonly Invite $invite;
    public readonly Sticker $sticker;
    public readonly GuildCommand $guildCommand;
    public readonly GlobalCommand $globalCommand;
    public readonly Webhook $webhook;
    public readonly Guild $guild;

    /**
     * @todo add
     * - Application Role Connection Metadata
     * - Guild
     * - Stage Instance
     * - User
     */
    public function __construct(private Http $http, private DataMapper $dataMapper, private LoggerInterface $logger)
    {
        $args = [$this->http, $this->dataMapper, $this->logger];

        $this->application = new Application(...$args);
        $this->auditLog = new AuditLog(...$args);
        $this->channel = new Channel(...$args);
        $this->emoji = new Emoji(...$args);
        $this->guildAutoModeration = new GuildAutoModeration(...$args);
        $this->guildScheduledEvent = new GuildScheduledEvent(...$args);
        $this->guildSticker = new GuildSticker(...$args);
        $this->guildTemplate = new GuildTemplate(...$args);
        $this->invite = new Invite(...$args);
        $this->sticker = new Sticker(...$args);
        $this->guildCommand = new GuildCommand(...$args);
        $this->globalCommand = new GlobalCommand(...$args);
        $this->webhook = new Webhook(...$args);
        $this->guild = new Guild(...$args);
    }
}
