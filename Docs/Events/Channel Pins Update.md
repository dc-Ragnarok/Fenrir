#### Event
`CHANNEL_PINS_UPDATE`

#### Required Intents
- `GUILDS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`null`&#124;`string`|
|`channel_id`|`string`|
|`last_pin_timestamp`|`Carbon\Carbon`&#124;`null`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\ChannelPinsUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::CHANNEL_PINS_UPDATE, function (ChannelPinsUpdate $event) {
    // Handle event
});
```
