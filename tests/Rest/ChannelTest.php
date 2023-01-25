<?php

use Discord\Http\Endpoint;
use Discord\Http\Http;
use Exan\Dhp\Parts\Channel as PartsChannel;
use Exan\Dhp\Rest\Channel;
use PHPUnit\Framework\TestCase;
use React\Promise\Promise;
use seregazhuk\React\PromiseTesting\AssertsPromise;

class ChannelTest extends TestCase
{
    use AssertsPromise;

    protected Http $http;

    protected $httpItem;

    protected function setUp(): void
    {
        $this->http = Mockery::mock(Http::class);

        $jsonMapper = new JsonMapper();
        $jsonMapper->bStrictNullTypes = false;

        $this->httpItem = new Channel($this->http, $jsonMapper);
    }

    /**
     * @dataProvider httpBindingsProvider
     */
    public function testFunctions(string $method, array $args = [], array $mockOptions, array $validationOptions)
    {
        $this->http->shouldReceive($mockOptions['method'])->andReturns(
            new Promise(function ($resolve) use ($mockOptions) {
                $resolve($mockOptions['return']);
            })
        )->once();

        $response = call_user_func_array([$this->httpItem, $method], $args);

        $this->assertPromiseFulfillsWithInstanceOf($response, $validationOptions['returnType']);

        $this->http->shouldHaveReceived($mockOptions['method']);
    }

    public function httpBindingsProvider(): array
    {
        return [
            'get' => [
                'method' => 'get',
                'args' => ['::channel id::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => PartsChannel::class,
                ]
            ]
        ];
    }
}
