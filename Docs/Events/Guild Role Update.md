#### Event
`GUILD_ROLE_UPDATE`

#### Required Intents
- `GUILD_MEMBERS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`role`|`Ragnarok\Fenrir\Parts\Role`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildRoleUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::GUILD_ROLE_UPDATE, function (GuildRoleUpdate $event) {
    // Handle event
});
```
