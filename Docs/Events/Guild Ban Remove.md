#### Event
`GUILD_BAN_REMOVE`

#### Required Intents
- `GUILD_MODERATION`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`user`|`Ragnarok\Fenrir\Parts\User`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildBanRemove;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::GUILD_BAN_REMOVE, function (GuildBanRemove $event) {
    // Handle event
});
```
