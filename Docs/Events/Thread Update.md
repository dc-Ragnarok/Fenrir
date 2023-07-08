#### Event
`THREAD_UPDATE`

#### Required Intents
- `GUILDS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`null`&#124;`string`|
|`channel_ids`|`array`|
|`threads`|`array`|
|`members`|`array`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\ThreadUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::THREAD_UPDATE, function (ThreadUpdate $event) {
    // Handle event
});
```
