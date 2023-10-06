#### Event
`GUILD_BAN_ADD`

#### Required Intents
- `GUILD_MODERATION`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`user`|`Ragnarok\Fenrir\Parts\User`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildBanAdd;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::GUILD_BAN_ADD, function (GuildBanAdd $event) {
    // Handle event
});
```
