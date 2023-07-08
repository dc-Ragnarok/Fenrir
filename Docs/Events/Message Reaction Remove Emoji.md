#### Event
`MESSAGE_REACTION_REMOVE_EMOJI`

#### Required Intents
- `GUILD_MESSAGE_REACTIONS`
- `DIRECT_MESSAGE_REACTIONS`

#### Properties
|property|type|
|--------|----|
|`channel_id`|`string`|
|`guild_id`|`null`&#124;`string`|
|`message_id`|`string`|
|`emoji`|`Ragnarok\Fenrir\Parts\Emoji`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\MessageReactionRemoveEmoji;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::MESSAGE_REACTION_REMOVE_EMOJI, function (MessageReactionRemoveEmoji $event) {
    // Handle event
});
```
