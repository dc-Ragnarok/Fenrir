#### Event
`USER_UPDATE`

#### Required Intents

#### Properties
|property|type|
|--------|----|
|`id`|`string`|
|`username`|`string`|
|`global_name`|`null`&#124;`string`|
|`discriminator`|`string`|
|`avatar`|`null`&#124;`string`|
|`bot`|`bool`&#124;`null`|
|`system`|`bool`&#124;`null`|
|`mfa_enabled`|`bool`&#124;`null`|
|`banner`|`null`&#124;`string`|
|`accent_color`|`int`&#124;`null`|
|`locale`|`null`&#124;`string`|
|`verified`|`bool`|
|`email`|`null`&#124;`string`|
|`flags`|`Ragnarok\Fenrir\Bitwise\Bitwise`&#124;`null`|
|`premium_type`|`Ragnarok\Fenrir\Enums\PremiumTier`&#124;`null`|
|`public_flags`|`Ragnarok\Fenrir\Bitwise\Bitwise`&#124;`null`|
|`member`|`Ragnarok\Fenrir\Parts\GuildMember`&#124;`null`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\UserUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::USER_UPDATE, function (UserUpdate $event) {
    // Handle event
});
```
