#### Event
`PRESENCE_UPDATE`

#### Required Intents
- `GUILD_PRESENCES`

#### Properties
|property|type|
|--------|----|
|`user`|`Ragnarok\Fenrir\Parts\User`|
|`guild_id`|`string`|
|`status`|`string`|
|`activities`|`array`|
|`clientStatus`|`Ragnarok\Fenrir\Parts\ClientStatus`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\PresenceUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::PRESENCE_UPDATE, function (PresenceUpdate $event) {
    // Handle event
});
```
