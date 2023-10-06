#### Event
`GUILD_SCHEDULED_EVENT_USER_ADD`

#### Required Intents
- `GUILD_SCHEDULED_EVENTS`

#### Properties
|property|type|
|--------|----|
|`guild_scheduled_event_id`|`string`|
|`user_id`|`string`|
|`guild_id`|`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildScheduledEventUserAdd;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::GUILD_SCHEDULED_EVENT_USER_ADD, function (GuildScheduledEventUserAdd $event) {
    // Handle event
});
```
