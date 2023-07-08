#### Event
`THREAD_MEMBERS_UPDATE`

#### Required Intents
- `GUILDS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`null`&#124;`string`|
|`id`|`null`&#124;`string`|
|`user_id`|`null`&#124;`string`|
|`join_timestamp`|`Carbon\Carbon`|
|`flags`|`Ragnarok\Fenrir\Bitwise\Bitwise`|
|`member`|`Ragnarok\Fenrir\Parts\GuildMember`&#124;`null`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\ThreadMembersUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::THREAD_MEMBERS_UPDATE, function (ThreadMembersUpdate $event) {
    // Handle event
});
```
