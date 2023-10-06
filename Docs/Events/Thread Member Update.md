#### Event
`THREAD_MEMBER_UPDATE`

#### Required Intents
- `GUILDS`

#### Properties
|property|type|
|--------|----|
|`id`|`string`|
|`guild_id`|`null`&#124;`string`|
|`member_count`|`int`|
|`added_members`|`array`&#124;`null`|
|`removed_member_ids`|`array`&#124;`null`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\ThreadMemberUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::THREAD_MEMBER_UPDATE, function (ThreadMemberUpdate $event) {
    // Handle event
});
```
