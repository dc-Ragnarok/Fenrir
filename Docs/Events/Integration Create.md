#### Event
`INTEGRATION_CREATE`

#### Required Intents
- `GUILD_INTEGRATIONS`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`id`|`string`|
|`name`|`string`|
|`type`|`string`|
|`enabled`|`bool`|
|`syncing`|`bool`&#124;`null`|
|`role_id`|`null`&#124;`string`|
|`enable_emoticons`|`bool`&#124;`null`|
|`expire_behavior`|`Ragnarok\Fenrir\Enums\IntegrationExpireBehavior`&#124;`null`|
|`expire_grace_period`|`int`&#124;`null`|
|`user`|`Ragnarok\Fenrir\Parts\User`&#124;`null`|
|`account`|`Ragnarok\Fenrir\Parts\Account`|
|`synced_at`|`Carbon\Carbon`&#124;`null`|
|`subscriber_count`|`int`&#124;`null`|
|`revoked`|`bool`&#124;`null`|
|`application`|`Ragnarok\Fenrir\Parts\Application`&#124;`null`|
|`scopes`|`array`&#124;`null`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\IntegrationCreate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::INTEGRATION_CREATE, function (IntegrationCreate $event) {
    // Handle event
});
```
