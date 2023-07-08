#### Event
`MESSAGE_REACTION_REMOVE_ALL`

#### Required Intents
- `GUILD_MESSAGE_REACTIONS`
- `DIRECT_MESSAGE_REACTIONS`

#### Properties
|property|type|
|--------|----|
|`channel_id`|`string`|
|`message_id`|`string`|
|`guild_id`|`null`&#124;`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\MessageReactionRemoveAll;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::MESSAGE_REACTION_REMOVE_ALL, function (MessageReactionRemoveAll $event) {
    // Handle event
});
```
