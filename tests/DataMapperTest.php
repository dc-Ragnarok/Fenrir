<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir;

use Monolog\Test\TestCase;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\Enums\ApplicationCommandOptionType;
use Ragnarok\Fenrir\Gateway\Events\InteractionCreate;
use Ragnarok\Fenrir\Parts\ApplicationCommandInteractionDataOptionStructure;
use Ragnarok\Fenrir\Parts\InteractionData;
use Ragnarok\Fenrir\Parts\Message;

class DataMapperTest extends TestCase
{
    private function getDataMapper(?LoggerInterface $logger = new NullLogger()): DataMapper
    {
        return new DataMapper(
            $logger
        );
    }

    public function testItMapsDataFromObject(): void
    {
        $data = (object) [
            'id' => '::id::',
            'channel_id' => '::channel id::',
            'tts' => true,
            'position' => 20,
        ];

        /** @var Message */
        $output = $this->getDataMapper()->map($data, Message::class);

        $this->assertInstanceOf(Message::class, $output);
        $this->assertEquals('::id::', $output->id);
        $this->assertEquals('::channel id::', $output->channel_id);
    }

    public function testItDoesNotFailHardOnImpossibleJuggles(): void
    {
        $data = (object) [
            'reactions' => 'this is supposed to be an array',
            'position' => 'ten'
        ];

        /** @var Message */
        $output = $this->getDataMapper()->map($data, Message::class);

        // No values should be filled, but type should match
        $this->assertInstanceOf(Message::class, $output);
        $this->assertEquals(new Message(), $output);
    }

    public function testItMapsRecursively(): void
    {
        $data = (object) [
            'id' => '::interaction id::',
            'data' => (object) [
                'id' => '::interaction data id::',
            ],
        ];

        /** @var InteractionCreate */
        $output = $this->getDataMapper()->map($data, InteractionCreate::class);

        $this->assertInstanceOf(InteractionCreate::class, $output);
        $this->assertEquals('::interaction id::', $output->id);

        $this->assertInstanceOf(InteractionData::class, $output->data);
        $this->assertEquals('::interaction data id::', $output->data->id);
    }

    public function testItMapsArrays(): void
    {
        $data = (object) [
            'id' => '::interaction id::',
            'token' => '::token::',
            'application_id' => '::application id::',
            'data' => (object) [
                'options' => [
                    (object) [
                        'name' => '::option name:: 0',
                    ],
                    (object) [
                        'name' => '::option name:: 1',
                    ],
                    (object) [
                        'name' => '::option name:: 2',
                    ]
                ],
            ],
        ];

        /** @var InteractionCreate */
        $output = $this->getDataMapper()->map($data, InteractionCreate::class);

        $this->assertInstanceOf(InteractionCreate::class, $output);

        $this->assertInstanceOf(InteractionData::class, $output->data);

        $this->assertCount(3, $output->data->options);
        foreach ($output->data->options as $key => $value) {
            $this->assertInstanceOf(ApplicationCommandInteractionDataOptionStructure::class, $value);
            $this->assertEquals('::option name:: ' . $key, $value->name);
        }
    }
}
