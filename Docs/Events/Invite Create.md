#### Event
`INVITE_CREATE`

#### Required Intents
- `GUILD_INVITES`

#### Properties
|property|type|
|--------|----|
|`channel_id`|`string`|
|`code`|`string`|
|`created_at`|`Carbon\Carbon`|
|`guild_id`|`null`&#124;`string`|
|`inviter`|`Ragnarok\Fenrir\Parts\User`&#124;`null`|
|`max_age`|`int`|
|`max_uses`|`int`|
|`target_type`|`Ragnarok\Fenrir\Enums\TargetType`|
|`target_user`|`Ragnarok\Fenrir\Parts\User`&#124;`null`|
|`target_application`|`Ragnarok\Fenrir\Parts\Application`&#124;`null`|
|`temporary`|`bool`|
|`uses`|`bool`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\InviteCreate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::INVITE_CREATE, function (InviteCreate $event) {
    // Handle event
});
```
