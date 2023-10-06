#### Event
`STAGE_INSTANCE_CREATE`

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
use Ragnarok\Fenrir\Gateway\Events\StageInstanceCreate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::STAGE_INSTANCE_CREATE, function (StageInstanceCreate $event) {
    // Handle event
});
```
