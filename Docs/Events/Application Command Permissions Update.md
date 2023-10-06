#### Event
`APPLICATION_COMMAND_PERMISSIONS_UPDATE`

#### Required Intents
- `AUTO_MODERATION_CONFIGURATION`

#### Properties
|property|type|
|--------|----|
|`id`|`string`|
|`application_id`|`string`|
|`permission`|`bool`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\ApplicationCommandPermissionsUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::APPLICATION_COMMAND_PERMISSIONS_UPDATE, function (ApplicationCommandPermissionsUpdate $event) {
    // Handle event
});
```
