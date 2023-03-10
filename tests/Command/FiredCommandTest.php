<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Command;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Exan\Fenrir\Command\FiredCommand;
use Exan\Fenrir\Command\Helpers\InteractionCallbackBuilder;
use Exan\Fenrir\Parts\ApplicationCommandInteractionDataOptionStructure;
use Exan\Fenrir\Parts\InteractionData;
use Exan\Fenrir\Rest\Helpers\Webhook\EditWebhookBuilder;
use Exan\Fenrir\Websocket\Events\InteractionCreate;
use JsonMapper;
use Tests\Exan\Fenrir\Helpers\FakeComponents;

class FiredCommandTest extends MockeryTestCase
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
        $discord = FakeComponents::getFakeDiscord();
        $interactionCallbackBuilder = Mockery::mock(InteractionCallbackBuilder::class);

        $discord->rest->webhook
            ->shouldReceive('createInteractionResponse')
            ->with('::interaction id::', '::interaction token::', $interactionCallbackBuilder)
            ->andReturn(FakeComponents::getFakePromise('::result::'))
            ->once();

        $firedCommand = new FiredCommand($this->getInteractionCreate(), $discord);

        $firedCommand->createInteractionResponse($interactionCallbackBuilder);
    }

    public function testGetInteractionResponse()
    {
        $discord = FakeComponents::getFakeDiscord();

        $discord->rest->webhook
            ->shouldReceive('getOriginalInteractionResponse')
            ->with('::application id::', '::interaction token::')
            ->andReturn(FakeComponents::getFakePromise())
            ->once();

        $firedCommand = new FiredCommand($this->getInteractionCreate(), $discord);

        $firedCommand->getInteractionResponse();
    }

    public function testEditOriginalInteractionResponse()
    {
        $discord = FakeComponents::getFakeDiscord();
        $editWebhookBuilder = Mockery::mock(EditWebhookBuilder::class);

        $discord->rest->webhook
            ->shouldReceive('editOriginalInteractionResponse')
            ->with('::application id::', '::interaction token::', $editWebhookBuilder)
            ->andReturn(FakeComponents::getFakePromise('::result::'))
            ->once();

        $firedCommand = new FiredCommand($this->getInteractionCreate(), $discord);

        $firedCommand->editInteractionResponse($editWebhookBuilder);
    }

    public function testDeleteInteractionResponse()
    {
        $discord = FakeComponents::getFakeDiscord();

        $discord->rest->webhook
            ->shouldReceive('deleteOriginalInteractionResponse')
            ->with('::application id::', '::interaction token::')
            ->once();

        $firedCommand = new FiredCommand($this->getInteractionCreate(), $discord);

        $firedCommand->deleteInteractionResponse();
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

        $firedCommand = new FiredCommand($interactionCreate, FakeComponents::getFakeDiscord());

        $this->assertTrue($firedCommand->hasOption('funny_name'));
        $this->assertFalse($firedCommand->hasOption('other_name'));

        $this->assertNull($firedCommand->getOption('other_name'));
        $this->assertEquals($interactionCreate->data->options[0], $firedCommand->getOption('funny_name'));
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

        $firedCommand = new FiredCommand($interactionCreate, FakeComponents::getFakeDiscord());

        $this->assertEquals('::option name::', $firedCommand->getSubCommandName());
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

        $firedCommand = new FiredCommand($interactionCreate, FakeComponents::getFakeDiscord());

        $this->assertEquals('group_name:option_name', $firedCommand->getSubCommandName());
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

        $firedCommand = new FiredCommand($interactionCreate, FakeComponents::getFakeDiscord());

        $this->assertNull($firedCommand->getSubCommandName());
    }
}
