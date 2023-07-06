<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Enums\ApplicationCommandOptionType;
use Ragnarok\Fenrir\Enums\ApplicationCommandTypes;
use Ragnarok\Fenrir\Exceptions\Rest\Helpers\Command\InvalidCommandNameException;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandOptionBuilder;

class CommandBuilderTest extends TestCase
{
    public function testSetName(): void
    {
        $commandBuilder = new CommandBuilder();
        $commandBuilder->setName('test_name');
        $this->assertEquals('test_name', $commandBuilder->getName());
        $this->assertEquals('test_name', $commandBuilder->get()['name']);
    }

    public function testSetNameLocalizations(): void
    {
        $commandBuilder = new CommandBuilder();
        $localizations = ['en_US' => 'test_name', 'fr_FR' => 'test_name_hon_hon'];
        $commandBuilder->setNameLocalizations($localizations);
        $this->assertEquals($localizations, $commandBuilder->getNameLocalizations());
        $this->assertEquals($localizations, $commandBuilder->get()['name_localizations']);
    }

    public function testItValidatesNames(): void
    {
        $commandBuilder = new CommandBuilder();

        $this->expectException(InvalidCommandNameException::class);

        $commandBuilder->setName('::colons arent allowed woo::');
    }

    public function testItValidatesLocalizationNames(): void
    {
        $commandBuilder = new CommandBuilder();

        $this->expectException(InvalidCommandNameException::class);

        $commandBuilder->setNameLocalizations(['en' => '::colons arent allowed woo::']);
    }

    public function testSetDescription(): void
    {
        $commandBuilder = new CommandBuilder();
        $commandBuilder->setDescription('::description::');
        $this->assertEquals('::description::', $commandBuilder->getDescription());
        $this->assertEquals('::description::', $commandBuilder->get()['description']);
    }

    public function testSetDescriptionLocalizations(): void
    {
        $commandBuilder = new CommandBuilder();
        $localizations = ['en_US' => '::description::', 'fr_FR' => '::baguette::'];
        $commandBuilder->setDescriptionLocalizations($localizations);
        $this->assertEquals($localizations, $commandBuilder->getDescriptionLocalizations());
        $this->assertEquals($localizations, $commandBuilder->get()['description_localizations']);
    }

    public function testAddOption(): void
    {
        $commandBuilder = new CommandBuilder();

        $optionBuilder = new CommandOptionBuilder();
        $optionBuilder->setType(ApplicationCommandOptionType::ATTACHMENT);

        $commandBuilder->addOption($optionBuilder);

        $this->assertEquals([$optionBuilder], $commandBuilder->getOptions());
        $this->assertEquals($optionBuilder->get(), $commandBuilder->get()['options'][0]);
    }

    public function testSetDefaultMemberPermissions(): void
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

    public function testSetDmPermission(): void
    {
        $commandBuilder = new CommandBuilder();
        $commandBuilder->setDmPermission(true);
        $this->assertTrue($commandBuilder->getDmPermission());
        $this->assertTrue($commandBuilder->get()['dm_permissions']);
    }

    public function testSetType(): void
    {
        $commandBuilder = new CommandBuilder();
        $type = ApplicationCommandTypes::CHAT_INPUT;
        $commandBuilder->setType($type);

        $this->assertEquals($type, $commandBuilder->getType());
        $this->assertEquals($type->value, $commandBuilder->get()['type']);
    }

    public function testSetNsfw(): void
    {
        $commandBuilder = new CommandBuilder();
        $commandBuilder->setNsfw(true);
        $this->assertTrue($commandBuilder->getNsfw());
        $this->assertTrue($commandBuilder->get()['nsfw']);
    }
}
