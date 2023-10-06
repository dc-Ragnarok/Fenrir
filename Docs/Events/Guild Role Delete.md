#### Event
`GUILD_ROLE_DELETE`

#### Required Intents
- `GUILD_MEMBERS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`role_id`|`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildRoleDelete;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::GUILD_ROLE_DELETE, function (GuildRoleDelete $event) {
    // Handle event
});
```
