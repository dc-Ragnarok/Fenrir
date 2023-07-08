#### Event
`VOICE_STATE_UPDATE`

#### Required Intents
- `GUILD_VOICE_STATES`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`null`&#124;`string`|
|`channel_id`|`null`&#124;`string`|
|`user_id`|`string`|
|`member`|`Ragnarok\Fenrir\Parts\GuildMember`&#124;`null`|
|`session_id`|`string`|
|`deaf`|`bool`|
|`mute`|`bool`|
|`self_deaf`|`bool`|
|`self_mute`|`bool`|
|`self_stream`|`bool`&#124;`null`|
|`self_video`|`bool`|
|`suppress`|`bool`|
|`request_to_speak_timestamp`|`Carbon\Carbon`&#124;`null`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\VoiceStateUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::VOICE_STATE_UPDATE, function (VoiceStateUpdate $event) {
    // Handle event
});
```
