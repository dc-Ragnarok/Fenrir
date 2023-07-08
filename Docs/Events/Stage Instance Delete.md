#### Event
`STAGE_INSTANCE_DELETE`

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
use Ragnarok\Fenrir\Gateway\Events\StageInstanceDelete;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::STAGE_INSTANCE_DELETE, function (StageInstanceDelete $event) {
    // Handle event
});
```
