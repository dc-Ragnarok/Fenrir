#### Event
`MESSAGE_UPDATE`

#### Required Intents
- `GUILD_MESSAGES`
- `DIRECT_MESSAGES`

#### Properties
|property|type|
|--------|----|
|`id`|`string`|
|`channel_id`|`string`|
|`author`|`Ragnarok\Fenrir\Parts\User`|
|`content`|`string`|
|`timestamp`|`Carbon\Carbon`|
|`edited_timestamp`|`Carbon\Carbon`&#124;`null`|
|`tts`|`bool`|
|`mention_everyone`|`bool`|
|`mentions`|`array`|
|`mention_roles`|`array`|
|`mention_channels`|`array`&#124;`null`|
|`attachments`|`array`|
|`embeds`|`array`|
|`reactions`|`array`&#124;`null`|
|`nonce`|`null`&#124;`string`|
|`pinned`|`bool`|
|`webhook_id`|`null`&#124;`string`|
|`type`|`Ragnarok\Fenrir\Enums\MessageType`|
|`activity`|`Ragnarok\Fenrir\Parts\MessageActivity`&#124;`null`|
|`application`|`Ragnarok\Fenrir\Parts\Application`&#124;`null`|
|`application_id`|`null`&#124;`string`|
|`message_reference`|`Ragnarok\Fenrir\Parts\MessageReference`&#124;`null`|
|`flags`|`Ragnarok\Fenrir\Bitwise\Bitwise`&#124;`null`|
|`referenced_message`|`Ragnarok\Fenrir\Parts\Message`&#124;`null`|
|`interaction`|`Ragnarok\Fenrir\Parts\MessageInteraction`&#124;`null`|
|`thread`|`Ragnarok\Fenrir\Parts\Channel`&#124;`null`|
|`components`|`array`|
|`sticker_items`|`array`&#124;`null`|
|`stickers`|`array`&#124;`null`|
|`position`|`int`&#124;`null`|
|`role_subscription_data`|`Ragnarok\Fenrir\Parts\RoleSubscriptionData`&#124;`null`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\MessageUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::MESSAGE_UPDATE, function (MessageUpdate $event) {
    // Handle event
});
```
