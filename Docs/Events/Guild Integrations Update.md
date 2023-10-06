#### Event
`GUILD_INTEGRATIONS_UPDATE`

#### Required Intents
- `GUILD_INTEGRATIONS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildIntegrationsUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::GUILD_INTEGRATIONS_UPDATE, function (GuildIntegrationsUpdate $event) {
    // Handle event
});
```
