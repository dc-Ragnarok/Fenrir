#### Event
`MESSAGE_REACTION_ADD`

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
|`member`|`Ragnarok\Fenrir\Parts\GuildMember`&#124;`null`|
|`emoji`|`Ragnarok\Fenrir\Parts\Emoji`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\MessageReactionAdd;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::MESSAGE_REACTION_ADD, function (MessageReactionAdd $event) {
    // Handle event
});
```
