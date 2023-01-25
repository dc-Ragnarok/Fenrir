<?php

declare(strict_types=1);

namespace Tests\Exan\Dhp\Rest\Helpers\Channel;

use Exan\Dhp\Rest\Helpers\AllowedMentionsBuilder;
use PHPUnit\Framework\TestCase;

class AllowedMentionsBuilderTest extends TestCase
{
    public function testAddRole()
    {
        $builder = new AllowedMentionsBuilder();
        $builder->addRole('12345');

        $this->assertContains('12345', $builder->get()['roles']);
        $this->assertContains('roles', $builder->get()['parse']);
    }

    public function testAddUser()
    {
        $builder = new AllowedMentionsBuilder();
        $builder->addUser('54321');

        $this->assertContains('54321', $builder->get()['users']);
        $this->assertContains('users', $builder->get()['parse']);
    }

    public function testMentionRepliedUser()
    {
        $builder = new AllowedMentionsBuilder();
        $builder->mentionRepliedUser();

        $this->assertTrue($builder->get()['replied_user']);
    }

    public function testAllowUsers()
    {
        $builder = new AllowedMentionsBuilder();
        $builder->allowUsers();

        $this->assertContains('users', $builder->get()['parse']);
    }

    public function testAllowRoles()
    {
        $builder = new AllowedMentionsBuilder();
        $builder->allowRoles();

        $this->assertContains('roles', $builder->get()['parse']);
    }
}
