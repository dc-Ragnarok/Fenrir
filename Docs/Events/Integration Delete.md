#### Event
`INTEGRATION_DELETE`

#### Required Intents
- `GUILD_INTEGRATIONS`

#### Properties
|property|type|
|--------|----|
|`id`|`string`|
|`guild_id`|`string`|
|`application_id`|`null`&#124;`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\IntegrationDelete;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::INTEGRATION_DELETE, function (IntegrationDelete $event) {
    // Handle event
});
```
