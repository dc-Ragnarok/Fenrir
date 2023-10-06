#### Event
`MESSAGE_REACTION_REMOVE`

#### Required Intents
- `GUILD_MESSAGE_REACTIONS`
- `DIRECT_MESSAGE_REACTIONS`

#### Properties
|property|type|
|--------|----|
|`user_id`|`string`|
|`channel_id`|`string`|
|`message_id`|`string`|
|`guild_id`|`null`&#124;`string`|
|`emoji`|`Ragnarok\Fenrir\Parts\Emoji`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\MessageReactionRemove;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::MESSAGE_REACTION_REMOVE, function (MessageReactionRemove $event) {
    // Handle event
});
```
