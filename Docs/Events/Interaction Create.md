#### Event
`INTERACTION_CREATE`

#### Required Intents
- `GUILD_INTEGRATIONS`

#### Properties
|property|type|
|--------|----|
|`id`|`string`|
|`application_id`|`string`|
|`type`|`Ragnarok\Fenrir\Enums\InteractionType`|
|`data`|`Ragnarok\Fenrir\Parts\InteractionData`&#124;`null`|
|`guild_id`|`null`&#124;`string`|
|`channel_id`|`null`&#124;`string`|
|`member`|`Ragnarok\Fenrir\Parts\GuildMember`&#124;`null`|
|`user`|`Ragnarok\Fenrir\Parts\User`|
|`token`|`string`|
|`version`|`int`|
|`message`|`Ragnarok\Fenrir\Parts\Message`&#124;`null`|
|`app_permissions`|`null`&#124;`string`|
|`locale`|`null`&#124;`string`|
|`guild_locale`|`string`|
|`channel`|`Ragnarok\Fenrir\Parts\Channel`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\InteractionCreate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::INTERACTION_CREATE, function (InteractionCreate $event) {
    // Handle event
});
```
