#### Event
`THREAD_DELETE`

#### Required Intents
- `GUILDS`

#### Properties
|property|type|
|--------|----|
|`id`|`string`|
|`guild_id`|`null`&#124;`string`|
|`parent_id`|`null`&#124;`string`|
|`type`|`int`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\ThreadDelete;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::THREAD_DELETE, function (ThreadDelete $event) {
    // Handle event
});
```
