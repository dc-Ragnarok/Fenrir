<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Enums\AllowedMentionType;
use Ragnarok\Fenrir\Exceptions\Rest\EagerDiscordValidationException;

/**
 * @see https://discord.com/developers/docs/resources/channel#allowed-mentions-object
 */
class AllowedMentionsBuilder
{
    private array $parse = [];

    /**
     * @param string[] $roles Array of role_ids to mention (Max size of 100)
     * @param string[] $users Array of user_ids to mention (Max size of 100)
     * @param bool $replied_user For replies, whether to mention the author of the message being replied to
     * @param bool $everyone Whether to mention users with @everyone and @here
     *
     * @throws EagerDiscordValidationException
     */
    public function __construct(
        public readonly ?array $roles = null,
        public readonly ?array $users = null,
        public readonly ?bool $replied_user = null,
        public readonly ?bool $everyone = null,
    ) {
        if (!is_null($this->roles)) {
            if (count($this->roles) > 0) {
                $this->parse[] = AllowedMentionType::ROLES->value;
            }

            if (count($this->roles) > 100) {
                throw new EagerDiscordValidationException('Max of 100 roles exceeded');
            }
        }

        if (!is_null($this->users)) {
            if (count($this->users) > 0) {
                $this->parse[] = AllowedMentionType::USERS->value;
            }

            if (count($this->users) > 100) {
                throw new EagerDiscordValidationException('Max of 100 users exceeded');
            }
        }

        if ($this->everyone) {
            $this->parse[] = AllowedMentionType::EVERYONE->value;
        }
    }

    public function get(): array
    {
        $formatted = [
            'parse' => $this->parse,
        ];

        if (isset($this->roles)) {
            $formatted['roles'] = $this->roles;
        }

        if (isset($this->users)) {
            $formatted['users'] = $this->users;
        }

        if (isset($this->replied_user)) {
            $formatted['replied_user'] = $this->replied_user;
        }

        return $formatted;
    }
}
