#### Event
`STAGE_INSTANCE_UPDATE`

#### Required Intents
- `GUILDS`

#### Properties
|property|type|
|--------|----|
|`token`|`string`|
|`guild_id`|`string`|
|`endpoint`|`null`&#124;`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\StageInstanceUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::STAGE_INSTANCE_UPDATE, function (StageInstanceUpdate $event) {
    // Handle event
});
```
