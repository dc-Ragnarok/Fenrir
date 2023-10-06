#### Event
`GUILD_MEMBER_UPDATE`

#### Required Intents
- `GUILD_MEMBERS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`roles`|`array`|
|`user`|`Ragnarok\Fenrir\Parts\User`|
|`nick`|`null`&#124;`string`|
|`avatar`|`null`&#124;`string`|
|`joined_at`|`Carbon\Carbon`&#124;`null`|
|`premium_since`|`Carbon\Carbon`&#124;`null`|
|`deaf`|`bool`&#124;`null`|
|`mute`|`bool`&#124;`null`|
|`pending`|`bool`&#124;`null`|
|`communication_disabled_until`|`Carbon\Carbon`&#124;`null`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildMemberUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::GUILD_MEMBER_UPDATE, function (GuildMemberUpdate $event) {
    // Handle event
});
```
