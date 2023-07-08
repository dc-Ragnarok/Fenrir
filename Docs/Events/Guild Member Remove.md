#### Event
`GUILD_MEMBER_REMOVE`

#### Required Intents
- `GUILD_MEMBERS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`user`|`Ragnarok\Fenrir\Parts\User`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildMemberRemove;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::GUILD_MEMBER_REMOVE, function (GuildMemberRemove $event) {
    // Handle event
});
```
