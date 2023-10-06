#### Event
`INVITE_DELETE`

#### Required Intents
- `GUILD_INVITES`

#### Properties
|property|type|
|--------|----|
|`channel_id`|`string`|
|`guild_id`|`null`&#124;`string`|
|`code`|`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\InviteDelete;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::INVITE_DELETE, function (InviteDelete $event) {
    // Handle event
});
```
