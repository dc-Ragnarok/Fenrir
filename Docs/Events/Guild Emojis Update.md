#### Event
`GUILD_EMOJIS_UPDATE`

#### Required Intents
- `GUILD_EMOJIS_AND_STICKERS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`emojis`|`array`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildEmojisUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::GUILD_EMOJIS_UPDATE, function (GuildEmojisUpdate $event) {
    // Handle event
});
```
