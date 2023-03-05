<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/resources/channel#allowed-mentions-object
 */
class AllowedMentionsBuilder
{
    use GetNew;

    private array $data = [
        'parse' => [],
        'roles' => [],
        'users' => [],
    ];

    public function get(): array
    {
        return $this->data;
    }

    public function addRole(string $roleId): AllowedMentionsBuilder
    {
        $this->data['roles'][] = $roleId;

        if (!$this->allowsRoles()) {
            $this->allowRoles();
        }

        return $this;
    }

    public function addUser(string $userId): AllowedMentionsBuilder
    {
        $this->data['users'][] = $userId;

        if (!$this->allowsUsers()) {
            $this->allowUsers();
        }

        return $this;
    }

    public function mentionRepliedUser()
    {
        $this->data['replied_user'] = true;
    }

    public function allowUsers(): AllowedMentionsBuilder
    {
        $this->data['parse'][] = 'users';

        return $this;
    }

    protected function allowsUsers(): bool
    {
        return in_array('users', $this->data['parse']);
    }

    public function allowRoles(): AllowedMentionsBuilder
    {
        $this->data['parse'][] = 'roles';

        return $this;
    }

    protected function allowsRoles(): bool
    {
        return in_array('roles', $this->data['parse']);
    }
}
