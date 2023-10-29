<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Mapping;

use Carbon\Carbon;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Enums\MessageType;
use Ragnarok\Fenrir\Mapping\ArrayMapping;
use Ragnarok\Fenrir\Mapping\Mapper;
use Ragnarok\Fenrir\Parts\EmbedField;

class MapperTest extends TestCase
{
    private Mapper $mapper;

    protected function setUp(): void
    {
        $this->mapper = new Mapper();
    }

    public function testItMapsIntoObjectsUsingConstructor(): void
    {
        $datetime = Carbon::now();
        $source = $datetime->toIso8601String();

        $result = $this->mapper->map($source, Carbon::class);

        $this->assertInstanceOf(Carbon::class, $result->result);
        $this->assertEquals($source, $result->result->toIso8601String());
        $this->assertEmpty($result->errors);
    }

    public function testItCreatesAnObjectAndSetsScalarProperties(): void
    {
        $definition = new class () {
            public bool $boolTest;
            public int $intTest;
            public float $floatTest;
            public string $stringTest;
            public array $arrayTest;
        };

        $result = $this->mapper->map((object) [
            'boolTest' => true,
            'intTest' => 123,
            'floatTest' => 123.456,
            'stringTest' => 'Hello',
            'arrayTest' => ['Hello', 'world'],
        ], $definition::class);

        $this->assertInstanceOf($definition::class, $result->result);
        $this->assertEquals(true, $result->result->boolTest);
        $this->assertEquals(123, $result->result->intTest);
        $this->assertEquals(123.456, $result->result->floatTest);
        $this->assertEquals('Hello', $result->result->stringTest);
        $this->assertEquals(['Hello', 'world'], $result->result->arrayTest);
        $this->assertEmpty($result->errors);
    }

    public function testItNonTypedProperties(): void
    {
        $definition = new class () {
            public $test;
        };

        $result = $this->mapper->map((object) [
            'test' => 'Hello',
        ], $definition::class);

        $this->assertInstanceOf($definition::class, $result->result);
        $this->assertEquals('Hello', $result->result->test);
        $this->assertEmpty($result->errors);

        $result = $this->mapper->map((object) [
            'test' => true,
        ], $definition::class);

        $this->assertInstanceOf($definition::class, $result->result);
        $this->assertTrue($result->result->test);
        $this->assertEmpty($result->errors);
    }

    public function testItSetsUnionTypes(): void
    {
        $definition = new class () {
            public string|bool $test;
        };

        $result = $this->mapper->map((object) [
            'test' => 'Hello',
        ], $definition::class);

        $this->assertInstanceOf($definition::class, $result->result);
        $this->assertEquals('Hello', $result->result->test);
        $this->assertEmpty($result->errors);

        $result = $this->mapper->map((object) [
            'test' => true,
        ], $definition::class);

        $this->assertInstanceOf($definition::class, $result->result);
        $this->assertTrue($result->result->test);
        $this->assertEmpty($result->errors);
    }

    public function testItDoesNotSupportIntersectionTypes(): void
    {
        $definition = new class () {
            public Carbon&MockInterface $test;
        };

        $result = $this->mapper->map((object) [
            'test' => 'Hello',
        ], $definition::class);

        $this->assertInstanceOf($definition::class, $result->result);
        $this->assertFalse(isset($result->result->test));
        $this->assertNotEmpty($result->errors);
    }

    public function testItDoesNotAllowNonArraysToArrayMapping(): void
    {
        $definition = new class () {
            public array $test;
        };

        $result = $this->mapper->map((object) [
            'test' => 'Hello',
        ], $definition::class);

        $this->assertInstanceOf($definition::class, $result->result);
        $this->assertFalse(isset($result->result->test));
        $this->assertNotEmpty($result->errors);
    }

    public function testItAllowsTypedArrays()
    {
        $definition = new class () {
            #[ArrayMapping(EmbedField::class)]
            public array $test;
        };

        $source = (object) [
            'test' => [
                (object) [
                    'name' => '::name::',
                    'value' => '::value::',
                    'inline' => false,
                ],
            ],
        ];

        $result = $this->mapper->map($source, $definition::class);

        $this->assertInstanceOf($definition::class, $result->result);
        $this->assertEmpty($result->errors);

        $this->assertInstanceOf(EmbedField::class, $result->result->test[0]);
        $this->assertEquals('::name::', $result->result->test[0]->name);
        $this->assertEquals('::value::', $result->result->test[0]->value);
        $this->assertFalse($result->result->test[0]->inline);
    }

    public function testItSetsEnums(): void
    {
        $definition = new class () {
            public MessageType $test;
        };

        $result = $this->mapper->map((object) [
            'test' => 0,
        ], $definition::class);

        $this->assertInstanceOf($definition::class, $result->result);
        $this->assertEquals(MessageType::DEFAULT, $result->result->test);
        $this->assertEmpty($result->errors);
    }

    public function testItSetsClassTypedProperties(): void
    {
        $definition = new class () {
            public EmbedField $test;
        };

        $result = $this->mapper->map((object) [
            'test' => (object) [
                'name' => '::name::',
                'value' => '::value::',
                'inline' => false,
            ],
        ], $definition::class);

        $this->assertInstanceOf($definition::class, $result->result);
        $this->assertInstanceOf(EmbedField::class, $result->result->test);
        $this->assertEquals('::name::', $result->result->test->name);
        $this->assertEquals('::value::', $result->result->test->value);
        $this->assertFalse($result->result->test->inline);
        $this->assertEmpty($result->errors);
    }

    /**
     * @dataProvider incorrectAssignmentsProvider
     */
    public function testItReturnsErrorsForIncorrectAssignments(string $definition, $source)
    {
        $result = $this->mapper->map($source, $definition);

        $this->assertNotEmpty($result->errors);
    }

    public static function incorrectAssignmentsProvider()
    {
        return [
            'Non existing enum case, resulting on null on non-nullable prop' => (function () {
                $definition = new class () {
                    public MessageType $test;
                };

                return [
                    'definition' => $definition::class,
                    'source' => (object) [
                        'test' => 9001,
                    ],
                ];
            })(),

            'Instantiating class with wrong args' => (function () {
                $definition = new class ([]) {
                    public function __construct(array $test)
                    {
                    }
                };

                return [
                    'definition' => $definition::class,
                    'source' => 'hello world',
                ];
            })(),

            'Instantiating class with wrong args as property, resulting in null on non-nullable prop' => (function () {
                $definition = new class () {
                    public Discord $test;
                };

                return [
                    'definition' => $definition::class,
                    'source' => (object) [
                        'test' => [['hi there']]
                    ],
                ];
            })(),
        ];
    }
}
