#### Event
`TYPING_START`

#### Required Intents
- `GUILD_MESSAGE_TYPING`
- `DIRECT_MESSAGE_TYPING`

#### Properties
|property|type|
|--------|----|
|`channel_id`|`string`|
|`guild_id`|`null`&#124;`string`|
|`user_id`|`string`|
|`timestamp`|`Carbon\Carbon`|
|`member`|`Ragnarok\Fenrir\Parts\GuildMember`&#124;`null`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\TypingStart;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::TYPING_START, function (TypingStart $event) {
    // Handle event
});
```
