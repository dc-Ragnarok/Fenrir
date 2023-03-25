<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest;

use Exan\Fenrir\Parts\Invite;
use Exan\Fenrir\Rest\Invite as RestInvite;

class InviteTest extends HttpHelperTestCase
{
    protected string $httpItemClass = RestInvite::class;

    public function httpBindingsProvider(): array
    {
        return [
            'Get invite' => [
                'method' => 'get',
                'args' => ['::code::'],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => Invite::class,
                    'array' => true,
                ]
            ],
            'Delete invite' => [
                'method' => 'delete',
                'args' => ['::code::'],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => []
            ],
        ];
    }
}
