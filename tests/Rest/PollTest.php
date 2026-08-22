<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest;

use Ragnarok\Fenrir\Parts\Message;
use Ragnarok\Fenrir\Parts\PollAnswerVoters;
use Ragnarok\Fenrir\Rest\Poll;
use Tests\Ragnarok\Fenrir\Rest\HttpHelperTestCase;

class PollTest extends HttpHelperTestCase
{
    protected string $httpItemClass = Poll::class;

    public static function httpBindingsProvider(): array
    {
        return [
            'Get answer voters' => [
                'method' => 'getAnswerVoters',
                'args' => ['::channel id::', '::message id::', 1],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) ['users' => []],
                ],
                'validationOptions' => [
                    'returnType' => PollAnswerVoters::class,
                ],
            ],
            'Get answer voters with pagination' => [
                'method' => 'getAnswerVoters',
                'args' => ['::channel id::', '::message id::', 1, '::after::', 100],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) ['users' => []],
                ],
                'validationOptions' => [
                    'returnType' => PollAnswerVoters::class,
                ],
            ],
            'End poll' => [
                'method' => 'endPoll',
                'args' => ['::channel id::', '::message id::'],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => Message::class,
                ],
            ],
        ];
    }
}
