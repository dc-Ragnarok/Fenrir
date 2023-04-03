<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Ragnarok\Fenrir\Enums\Parts\ApplicationCommandOptionTypes;
use Ragnarok\Fenrir\Enums\Parts\ChannelTypes;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandOptionBuilder;
use Mockery;
use PHPUnit\Framework\TestCase;

class CommandOptionBuilderTest extends TestCase
{
    public function testGetType(): void
    {
        $builder = new CommandOptionBuilder();
        $this->assertNull($builder->getType());
        $builder->setType(ApplicationCommandOptionTypes::SUB_COMMAND);

        $this->assertEquals(ApplicationCommandOptionTypes::SUB_COMMAND, $builder->getType());
        $this->assertEquals(ApplicationCommandOptionTypes::SUB_COMMAND->value, $builder->get()['type']);
    }

    public function testSetName(): void
    {
        $builder = new CommandOptionBuilder();
        $this->assertNull($builder->getName());
        $builder->setName('option-name');

        $this->assertEquals('option-name', $builder->getName());
        $this->assertEquals('option-name', $builder->get()['name']);
    }

    public function testSetNameLocalizations(): void
    {
        $builder = new CommandOptionBuilder();
        $localizations = [
            "en_US" => "English Name",
            "es_ES" => "Nombre en español",
            "pt_BR" => "Nome em português"
        ];
        $builder->setNameLocalizations($localizations);

        $this->assertEquals($localizations, $builder->getNameLocalizations());
        $this->assertEquals($localizations, $builder->get()['name_localizations']);
    }

    public function testSetDescription(): void
    {
        $builder = new CommandOptionBuilder();
        $this->assertNull($builder->getDescription());
        $builder->setDescription('option-description');

        $this->assertEquals('option-description', $builder->getDescription());
        $this->assertEquals('option-description', $builder->get()['description']);
    }

    public function testSetDescriptionLocalizations(): void
    {
        $builder = new CommandOptionBuilder();
        $this->assertNull($builder->getDescriptionLocalizations());

        $descriptionLocalizations = [
            'en_US' => 'This is an option description',
            'fr_FR' => 'Ceci est une description d\'option'
        ];

        $builder->setDescriptionLocalizations($descriptionLocalizations);

        $this->assertEquals($descriptionLocalizations, $builder->get()['description_localizations']);
        $this->assertEquals($descriptionLocalizations, $builder->getDescriptionLocalizations());
    }

    public function testSetRequired(): void
    {
        $builder = new CommandOptionBuilder();
        $this->assertNull($builder->getRequired());
        $builder->setRequired(true);

        $this->assertTrue($builder->getRequired());
        $this->assertTrue($builder->get()['required']);
    }

    public function testAddChoice(): void
    {
        $builder = new CommandOptionBuilder();
        $this->assertEmpty($builder->getChoices());
        $builder->addChoice('choice-1', 'choice-value-1');
        $builder->addChoice('choice-2', 'choice-value-2');

        $this->assertEquals([
            ['name' => 'choice-1', 'value' => 'choice-value-1', 'localized_names' => []],
            ['name' => 'choice-2', 'value' => 'choice-value-2', 'localized_names' => []]
        ], $builder->getChoices());

        $this->assertEquals([
            ['name' => 'choice-1', 'value' => 'choice-value-1', 'localized_names' => []],
            ['name' => 'choice-2', 'value' => 'choice-value-2', 'localized_names' => []]
        ], $builder->get()['choices']);
    }

    public function testAddCommandOption(): void
    {
        $commandOptionBuilder = new CommandOptionBuilder();

        $this->assertNull($commandOptionBuilder->getOptions());

        $mockOption = Mockery::mock(CommandOptionBuilder::class);
        $mockOption->shouldReceive('get')->andReturn(['::option::']);

        $commandOptionBuilder->addOption($mockOption);

        $this->assertEquals([$mockOption], $commandOptionBuilder->getOptions());
        $this->assertEquals([['::option::']], $commandOptionBuilder->get()['options']);
    }

    public function testSetChannelTypes(): void
    {
        $commandOptionBuilder = CommandOptionBuilder::new();
        $this->assertNull($commandOptionBuilder->getChannelTypes());

        $commandOptionBuilder->setChannelTypes(ChannelTypes::GROUP_DM, ChannelTypes::GUILD_DIRECTORY);

        $this->assertEquals([
            ChannelTypes::GROUP_DM, ChannelTypes::GUILD_DIRECTORY
        ], $commandOptionBuilder->getChannelTypes());

        $this->assertEquals([
            ChannelTypes::GROUP_DM->value, ChannelTypes::GUILD_DIRECTORY->value
        ], $commandOptionBuilder->get()['channel_types']);
    }

    public function testSetMinValue(): void
    {
        $builder = new CommandOptionBuilder();
        $this->assertNull($builder->getMinValue());
        $builder->setMinValue(5);
        $this->assertEquals(5, $builder->getMinValue());
        $this->assertEquals(5, $builder->get()['min_value']);
    }

    public function testSetMaxValue(): void
    {
        $builder = new CommandOptionBuilder();
        $this->assertNull($builder->getMaxValue());
        $builder->setMaxValue(10);
        $this->assertEquals(10, $builder->getMaxValue());
        $this->assertEquals(10, $builder->get()['max_value']);
    }

    public function testSetMinLength(): void
    {
        $builder = new CommandOptionBuilder();
        $this->assertNull($builder->getMinLength());
        $builder->setMinLength(3);
        $this->assertEquals(3, $builder->getMinLength());
        $this->assertEquals(3, $builder->get()['min_length']);
    }

    public function testSetMaxLength(): void
    {
        $builder = new CommandOptionBuilder();
        $this->assertNull($builder->getMaxLength());
        $builder->setMaxLength(20);
        $this->assertEquals(20, $builder->getMaxLength());
        $this->assertEquals(20, $builder->get()['max_length']);
    }

    public function testSetAutoComplete(): void
    {
        $builder = new CommandOptionBuilder();

        $this->assertNull($builder->getAutoComplete());

        $builder->setAutoComplete(true);

        $this->assertTrue($builder->getAutoComplete());
        $this->assertTrue($builder->get()['autocomplete']);
    }
}
