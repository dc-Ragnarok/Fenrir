#### Event
`GUILD_ROLE_CREATE`

#### Required Intents
- `GUILDS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`role`|`Ragnarok\Fenrir\Parts\Role`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildRoleCreate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::GUILD_ROLE_CREATE, function (GuildRoleCreate $event) {
    // Handle event
});
```
