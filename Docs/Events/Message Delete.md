#### Event
`MESSAGE_DELETE`

#### Required Intents
- `GUILD_MESSAGES`
- `DIRECT_MESSAGES`

#### Properties
|property|type|
|--------|----|
|`id`|`string`|
|`channel_id`|`string`|
|`guild_id`|`null`&#124;`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\MessageDelete;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::MESSAGE_DELETE, function (MessageDelete $event) {
    // Handle event
});
```
