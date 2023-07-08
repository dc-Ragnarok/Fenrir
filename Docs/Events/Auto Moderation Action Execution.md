#### Event
`AUTO_MODERATION_ACTION_EXECUTION`

#### Required Intents
- `AUTO_MODERATION_EXECUTION`

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`action`|`Ragnarok\Fenrir\Parts\AutoModerationAction`|
|`rule_id`|`string`|
|`rule_trigger_types`|`Ragnarok\Fenrir\Enums\AutoModerationRuleTriggerType`|
|`user_id`|`string`|
|`channel_id`|`null`&#124;`string`|
|`message_id`|`null`&#124;`string`|
|`alert_system_message_id`|`null`&#124;`string`|
|`content`|`null`&#124;`string`|
|`matched_keyword`|`null`&#124;`string`|
|`matched_content`|`null`&#124;`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\AutoModerationActionExecution;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::AUTO_MODERATION_ACTION_EXECUTION, function (AutoModerationActionExecution $event) {
    // Handle event
});
```
