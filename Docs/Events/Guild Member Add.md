#### Event
`GUILD_MEMBER_ADD`

#### Required Intents
- `GUILD_MEMBERS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`user`|`Ragnarok\Fenrir\Parts\User`&#124;`null`|
|`nick`|`null`&#124;`string`|
|`avatar`|`null`&#124;`string`|
|`roles`|`array`|
|`joined_at`|`Carbon\Carbon`|
|`premium_since`|`Carbon\Carbon`&#124;`null`|
|`deaf`|`bool`|
|`mute`|`bool`|
|`flags`|`int`|
|`pending`|`bool`&#124;`null`|
|`permissions`|`null`&#124;`string`|
|`communication_disabled_until`|`Carbon\Carbon`&#124;`null`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildMemberAdd;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::GUILD_MEMBER_ADD, function (GuildMemberAdd $event) {
    // Handle event
});
```
