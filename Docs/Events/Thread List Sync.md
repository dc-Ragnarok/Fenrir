#### Event
`THREAD_LIST_SYNC`

#### Required Intents
- `GUILDS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`channel_ids`|`array`&#124;`null`|
|`threads`|`array`|
|`members`|`array`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\ThreadListSync;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::THREAD_LIST_SYNC, function (ThreadListSync $event) {
    // Handle event
});
```
