#### Event
`GUILD_STICKERS_UPDATE`

#### Required Intents
- `GUILD_EMOJIS_AND_STICKERS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`stickers`|`array`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildStickersUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::GUILD_STICKERS_UPDATE, function (GuildStickersUpdate $event) {
    // Handle event
});
```
