#### Event
`GUILD_SCHEDULED_EVENT_UPDATE`

#### Required Intents
- `GUILD_SCHEDULED_EVENTS`

#### Properties
|property|type|
|--------|----|
|`id`|`string`|
|`guild_id`|`string`|
|`channel_id`|`null`&#124;`string`|
|`creator_id`|`null`&#124;`string`|
|`name`|`string`|
|`description`|`null`&#124;`string`|
|`scheduled_start_time`|`Carbon\Carbon`|
|`scheduled_end_time`|`Carbon\Carbon`&#124;`null`|
|`privacy_level`|`Ragnarok\Fenrir\Enums\GuildScheduledEventPrivacyLevel`|
|`status`|`Ragnarok\Fenrir\Enums\GuildScheduledEventStatus`|
|`entity_type`|`Ragnarok\Fenrir\Enums\GuildScheduledEventEntityType`|
|`entity_id`|`null`&#124;`string`|
|`entity_metadata`|`Ragnarok\Fenrir\Parts\GuildScheduledEventEntityMetadata`&#124;`null`|
|`creator`|`Ragnarok\Fenrir\Parts\User`|
|`user_count`|`int`&#124;`null`|
|`image`|`null`&#124;`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildScheduledEventUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::GUILD_SCHEDULED_EVENT_UPDATE, function (GuildScheduledEventUpdate $event) {
    // Handle event
});
```
