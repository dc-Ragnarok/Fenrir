<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Interaction;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Exan\Fenrir\Interaction\CommandInteraction;
use Exan\Fenrir\Interaction\Helpers\InteractionCallbackBuilder;
use Exan\Fenrir\Parts\ApplicationCommandInteractionDataOptionStructure;
use Exan\Fenrir\Parts\InteractionData;
use Exan\Fenrir\Rest\Helpers\Webhook\EditWebhookBuilder;
use Exan\Fenrir\Websocket\Events\InteractionCreate;
use JsonMapper;
use Fakes\Exan\Fenrir\DiscordFake;
use Fakes\Exan\Fenrir\PromiseFake;

class CommandInteractionTest extends MockeryTestCase
{
    private function getInteractionCreate(): InteractionCreate
    {
        $interactionCreate = new InteractionCreate();
        $interactionCreate->id = '::interaction id::';
        $interactionCreate->token = '::interaction token::';
        $interactionCreate->application_id = '::application id::';

        return $interactionCreate;
    }

    public function testCreateInteractionResponse()
    {
        $discord = DiscordFake::get();
        $interactionCallbackBuilder = Mockery::mock(InteractionCallbackBuilder::class);

        $discord->rest->webhook
            ->shouldReceive('createInteractionResponse')
            ->with('::interaction id::', '::interaction token::', $interactionCallbackBuilder)
            ->andReturn(PromiseFake::get('::result::'))
            ->once();

        $commandInteraction = new CommandInteraction($this->getInteractionCreate(), $discord);

        $commandInteraction->createInteractionResponse($interactionCallbackBuilder);
    }

    public function testGetInteractionResponse()
    {
        $discord = DiscordFake::get();

        $discord->rest->webhook
            ->shouldReceive('getOriginalInteractionResponse')
            ->with('::application id::', '::interaction token::')
            ->andReturn(PromiseFake::get())
            ->once();

        $commandInteraction = new CommandInteraction($this->getInteractionCreate(), $discord);

        $commandInteraction->getInteractionResponse();
    }

    public function testEditOriginalInteractionResponse()
    {
        $discord = DiscordFake::get();
        $editWebhookBuilder = Mockery::mock(EditWebhookBuilder::class);

        $discord->rest->webhook
            ->shouldReceive('editOriginalInteractionResponse')
            ->with('::application id::', '::interaction token::', $editWebhookBuilder)
            ->andReturn(PromiseFake::get('::result::'))
            ->once();

        $commandInteraction = new CommandInteraction($this->getInteractionCreate(), $discord);

        $commandInteraction->editInteractionResponse($editWebhookBuilder);
    }

    public function testDeleteInteractionResponse()
    {
        $discord = DiscordFake::get();

        $discord->rest->webhook
            ->shouldReceive('deleteOriginalInteractionResponse')
            ->with('::application id::', '::interaction token::')
            ->once();

        $commandInteraction = new CommandInteraction($this->getInteractionCreate(), $discord);

        $commandInteraction->deleteInteractionResponse();
    }

    public function testParsesOptions()
    {
        $interactionCreate = $this->getInteractionCreate();

        $interactionCreate->data = new InteractionData();
        $interactionCreate->data->options = [
            new ApplicationCommandInteractionDataOptionStructure()
        ];

        $interactionCreate->data->options[0]->name = 'funny_name';
        $interactionCreate->data->options[0]->value = '::value::';

        $commandInteraction = new CommandInteraction($interactionCreate, DiscordFake::get());

        $this->assertTrue($commandInteraction->hasOption('funny_name'));
        $this->assertFalse($commandInteraction->hasOption('other_name'));

        $this->assertNull($commandInteraction->getOption('other_name'));
        $this->assertEquals($interactionCreate->data->options[0], $commandInteraction->getOption('funny_name'));
    }

    public function testGetSubCommandName()
    {
        $jsonMapper = new JsonMapper();

        $interactionCreate = $jsonMapper->map(
            json_decode(json_encode([ // Json mapper requires object instead of array
                'id' => '::interaction id::',
                'token' => '::token::',
                'application_id' => '::application id::',
                'data' => [
                    'options' => [
                        [
                            'name' => '::option name::',
                            'type' => 1,
                        ]
                    ],
                ],
            ])),
            new InteractionCreate()
        );

        $commandInteraction = new CommandInteraction($interactionCreate, DiscordFake::get());

        $this->assertEquals('::option name::', $commandInteraction->getSubCommandName());
    }

    public function testGetSubCommandGroupName()
    {
        $jsonMapper = new JsonMapper();

        $interactionCreate = $jsonMapper->map(
            json_decode(json_encode([ // Json mapper requires object instead of array
                'id' => '::interaction id::',
                'token' => '::token::',
                'application_id' => '::application id::',
                'data' => [
                    'options' => [
                        [
                            'name' => 'group_name',
                            'type' => 2,
                            'options' => [
                                [
                                    'name' => 'option_name',
                                    'type' => 1,
                                ]
                            ],
                        ],
                    ],
                ],
            ])),
            new InteractionCreate()
        );

        $commandInteraction = new CommandInteraction($interactionCreate, DiscordFake::get());

        $this->assertEquals('group_name:option_name', $commandInteraction->getSubCommandName());
    }

    public function testGetSubCommandNameIsNullForRegularCommands()
    {
        $jsonMapper = new JsonMapper();

        $interactionCreate = $jsonMapper->map(
            json_decode(json_encode([ // Json mapper requires object instead of array
                'id' => '::interaction id::',
                'token' => '::token::',
                'application_id' => '::application id::',
                'data' => [
                    'options' => [
                        [
                            'name' => '::option name::',
                            'type' => 3,
                        ]
                    ],
                ],
            ])),
            new InteractionCreate()
        );

        $commandInteraction = new CommandInteraction($interactionCreate, DiscordFake::get());

        $this->assertNull($commandInteraction->getSubCommandName());
    }
}
