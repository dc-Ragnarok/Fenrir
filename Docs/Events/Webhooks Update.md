#### Event
`WEBHOOKS_UPDATE`

#### Required Intents
- `GUILD_WEBHOOKS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`channel_id`|`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\WebhooksUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::WEBHOOKS_UPDATE, function (WebhooksUpdate $event) {
    // Handle event
});
```
