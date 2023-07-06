<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest;

use Discord\Http\Http;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\Rest\HttpResource;
use Fakes\Ragnarok\Fenrir\DataMapperFake;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use React\Promise\Promise;

use function React\Async\await;

abstract class HttpHelperTestCase extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected HttpResource $httpItem;

    protected Http $http;

    protected DataMapper $dataMapper;

    protected LoggerInterface $mockLog;

    protected string $httpItemClass;

    protected function setUp(): void
    {
        $this->http = Mockery::mock(Http::class);

        $this->dataMapper = DataMapperFake::get();

        $this->mockLog = Mockery::mock(LoggerInterface::class);

        $this->httpItem = new $this->httpItemClass($this->http, $this->dataMapper, $this->mockLog);
    }

    abstract public function httpBindingsProvider(): array;

    /**
     * @dataProvider httpBindingsProvider
     */
    public function testFunctions(string $method, array $args, array $mockOptions, array $validationOptions): void
    {
        $this->http->shouldReceive($mockOptions['method'])->andReturns(
            new Promise(static function ($resolve) use ($mockOptions) {
                $resolve($mockOptions['return']);
            })
        )->once();

        $response = await(call_user_func_array([$this->httpItem, $method], $args));

        $this->http->shouldHaveReceived($mockOptions['method']);

        if (!isset($validationOptions['returnType'])) {
            return;
        }

        if (isset($validationOptions['array']) && $validationOptions['array'] === true) {
            foreach ($response as $item) {
                $this->assertInstanceOf($validationOptions['returnType'], $item);
            }
        } else {
            $this->assertInstanceOf($validationOptions['returnType'], $response);
        }
    }

    /**
     * @dataProvider httpBindingsProvider
     */
    public function testItLogsErrors(string $method, array $args, array $mockOptions, array $validationOptions): void
    {
        $this->mockLog->shouldReceive('error')->once();

        $this->http->shouldReceive($mockOptions['method'])->andReturns(
            new Promise(static function ($resolve, $reject) {
                $reject(new \Exception());
            })
        )->once();

        $promise = call_user_func_array([$this->httpItem, $method], $args);

        $this->mockLog->shouldHaveReceived('error');
    }
}
