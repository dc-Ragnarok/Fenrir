#### Event
`MESSAGE_DELETE_BULK`

#### Required Intents
- `GUILD_MESSAGES`

#### Properties
|property|type|
|--------|----|
|`ids`|`array`|
|`channel_id`|`string`|
|`guild_id`|`null`&#124;`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\MessageDeleteBulk;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::MESSAGE_DELETE_BULK, function (MessageDeleteBulk $event) {
    // Handle event
});
```
