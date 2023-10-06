#### Event
`VOICE_SERVER_UPDATE`

#### Required Intents

#### Properties
|property|type|
|--------|----|
|`token`|`string`|
|`guild_id`|`null`&#124;`string`|
|`endpoint`|`null`&#124;`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\VoiceServerUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::VOICE_SERVER_UPDATE, function (VoiceServerUpdate $event) {
    // Handle event
});
```
