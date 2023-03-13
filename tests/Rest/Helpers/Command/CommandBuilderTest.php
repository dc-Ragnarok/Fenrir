<?php

declare(strict_types=1);

namespace Exan\Fenrir;

use Exan\Fenrir\Bitwise\Bitwise;
use Exan\Fenrir\Enums\Parts\ApplicationCommandOptionTypes;
use Exan\Fenrir\Enums\Parts\ApplicationCommandTypes;
use Exan\Fenrir\Exceptions\Rest\Helpers\Command\InvalidCommandNameException;
use Exan\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Exan\Fenrir\Rest\Helpers\Command\CommandOptionBuilder;
use PHPUnit\Framework\TestCase;

class CommandBuilderTest extends TestCase
{
    public function testSetName()
    {
        $commandBuilder = new CommandBuilder();
        $commandBuilder->setName('test_name');
        $this->assertEquals('test_name', $commandBuilder->getName());
        $this->assertEquals('test_name', $commandBuilder->get()['name']);
    }

    public function testSetNameLocalizations()
    {
        $commandBuilder = new CommandBuilder();
        $localizations = ['en_US' => 'test_name', 'fr_FR' => 'test_name_hon_hon'];
        $commandBuilder->setNameLocalizations($localizations);
        $this->assertEquals($localizations, $commandBuilder->getNameLocalizations());
        $this->assertEquals($localizations, $commandBuilder->get()['name_localizations']);
    }

    public function testItValidatesNames()
    {
        $commandBuilder = new CommandBuilder();

        $this->expectException(InvalidCommandNameException::class);

        $commandBuilder->setName('::colons arent allowed woo::');
    }

    public function testItValidatesLocalizationNames()
    {
        $commandBuilder = new CommandBuilder();

        $this->expectException(InvalidCommandNameException::class);

        $commandBuilder->setNameLocalizations(['en' => '::colons arent allowed woo::']);
    }

    public function testSetDescription()
    {
        $commandBuilder = new CommandBuilder();
        $commandBuilder->setDescription('::description::');
        $this->assertEquals('::description::', $commandBuilder->getDescription());
        $this->assertEquals('::description::', $commandBuilder->get()['description']);
    }

    public function testSetDescriptionLocalizations()
    {
        $commandBuilder = new CommandBuilder();
        $localizations = ['en_US' => '::description::', 'fr_FR' => '::baguette::'];
        $commandBuilder->setDescriptionLocalizations($localizations);
        $this->assertEquals($localizations, $commandBuilder->getDescriptionLocalizations());
        $this->assertEquals($localizations, $commandBuilder->get()['description_localizations']);
    }

    public function testAddOption()
    {
        $commandBuilder = new CommandBuilder();

        $optionBuilder = new CommandOptionBuilder();
        $optionBuilder->setType(ApplicationCommandOptionTypes::ATTACHMENT);

        $commandBuilder->addOption($optionBuilder);

        $this->assertEquals([$optionBuilder], $commandBuilder->getOptions());
        $this->assertEquals($optionBuilder->get(), $commandBuilder->get()['options'][0]);
    }

    public function testSetDefaultMemberPermissions()
    {
        $commandBuilder = new CommandBuilder();
        $permissions = Bitwise::from(
            1 << 1,
            1 << 2
        );

        $commandBuilder->setDefaultMemberPermissions($permissions);

        $this->assertEquals($permissions->get(), $commandBuilder->getDefaultMemberPermissions()->get());
        $this->assertEquals($permissions->getBitSet(), $commandBuilder->get()['default_member_permissions']);
    }

    public function testSetDmPermission()
    {
        $commandBuilder = new CommandBuilder();
        $commandBuilder->setDmPermission(true);
        $this->assertTrue($commandBuilder->getDmPermission());
        $this->assertTrue($commandBuilder->get()['dm_permissions']);
    }

    public function testSetType()
    {
        $commandBuilder = new CommandBuilder();
        $type = ApplicationCommandTypes::CHAT_INPUT;
        $commandBuilder->setType($type);

        $this->assertEquals($type, $commandBuilder->getType());
        $this->assertEquals($type->value, $commandBuilder->get()['type']);
    }

    public function testSetNsfw()
    {
        $commandBuilder = new CommandBuilder();
        $commandBuilder->setNsfw(true);
        $this->assertTrue($commandBuilder->getNsfw());
        $this->assertTrue($commandBuilder->get()['nsfw']);
    }
}
