<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Rest\Helpers\Channel\AllowedMentionsBuilder;
use PHPUnit\Framework\TestCase;

class AllowedMentionsBuilderTest extends TestCase
{
    public function testAddRole(): void
    {
        $builder = new AllowedMentionsBuilder();

        $this->assertEquals([], $builder->getRoles());

        $builder->addRole('12345');

        $this->assertContains('12345', $builder->get()['roles']);
        $this->assertContains('roles', $builder->get()['parse']);
        $this->assertEquals(['12345'], $builder->getRoles());
    }

    public function testAddUser(): void
    {
        $builder = new AllowedMentionsBuilder();
        $this->assertEquals([], $builder->getUsers());
        $builder->addUser('54321');

        $this->assertContains('54321', $builder->get()['users']);
        $this->assertContains('users', $builder->get()['parse']);
        $this->assertEquals(['54321'], $builder->getUsers());
    }

    public function testMentionRepliedUser(): void
    {
        $builder = new AllowedMentionsBuilder();
        $this->assertFalse($builder->mentionsRepliedUser());
        $builder->mentionRepliedUser();

        $this->assertTrue($builder->get()['replied_user']);
        $this->assertTrue($builder->mentionsRepliedUser());
    }

    public function testAllowUsers(): void
    {
        $builder = new AllowedMentionsBuilder();
        $builder->allowUsers();

        $this->assertContains('users', $builder->get()['parse']);
    }

    public function testAllowRoles(): void
    {
        $builder = new AllowedMentionsBuilder();
        $builder->allowRoles();

        $this->assertContains('roles', $builder->get()['parse']);
    }
}
