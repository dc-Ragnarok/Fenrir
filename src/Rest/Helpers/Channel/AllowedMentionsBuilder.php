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

    public function addRole(string $roleId): self
    {
        $this->data['roles'][] = $roleId;

        if (!$this->allowsRoles()) {
            $this->allowRoles();
        }

        return $this;
    }

    public function getRoles(): array
    {
        return $this->data['roles'];
    }

    public function addUser(string $userId): self
    {
        $this->data['users'][] = $userId;

        if (!$this->allowsUsers()) {
            $this->allowUsers();
        }

        return $this;
    }

    public function getUsers(): array
    {
        return $this->data['users'];
    }

    public function mentionRepliedUser(): self
    {
        $this->data['replied_user'] = true;

        return $this;
    }

    public function mentionsRepliedUser(): bool
    {
        return isset($this->data['replied_user']) && $this->data['replied_user'];
    }

    public function allowUsers(): self
    {
        $this->data['parse'][] = 'users';

        return $this;
    }

    protected function allowsUsers(): bool
    {
        return in_array('users', $this->data['parse']);
    }

    public function allowRoles(): self
    {
        $this->data['parse'][] = 'roles';

        return $this;
    }

    protected function allowsRoles(): bool
    {
        return in_array('roles', $this->data['parse']);
    }
}
