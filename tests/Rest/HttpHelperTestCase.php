<?php

declare(strict_types=1);

namespace Tests\Exan\Dhp\Rest;

use Discord\Http\Http;
use JsonMapper;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use React\EventLoop\Loop;
use React\Promise\Promise;
use seregazhuk\React\PromiseTesting\AssertsPromise;

use function Clue\React\Block\await;

abstract class HttpHelperTestCase extends TestCase
{
    use AssertsPromise;
    use MockeryPHPUnitIntegration;

    protected $httpItem;

    protected Http $http;

    protected JsonMapper $jsonMapper;

    protected function setUp(): void
    {
        $this->http = Mockery::mock(Http::class);

        $this->jsonMapper = new JsonMapper();
        $this->jsonMapper->bStrictNullTypes = false;
    }

    abstract public function httpBindingsProvider(): array;

    /**
     * @dataProvider httpBindingsProvider
     */
    public function testFunctions(string $method, array $args = [], array $mockOptions, array $validationOptions)
    {
        $this->http->shouldReceive($mockOptions['method'])->andReturns(
            new Promise(function ($resolve) use ($mockOptions) {
                /**
                 * Promise resolving immediately can cause issues for strict
                 * return types.
                 */
                // (Loop::get())->addTimer(0.01, function () use ($resolve, $mockOptions) {
                $resolve($mockOptions['return']);
                // });
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
}
