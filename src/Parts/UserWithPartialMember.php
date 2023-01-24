<?php

namespace Exan\Dhp\Parts;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-create "mentions"
 * @todo
 */
class UserWithPartialMember extends User
{
    public PartialMember $member;
}
