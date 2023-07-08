#### Event
`AUTO_MODERATION_RULE_CREATE`

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
use Ragnarok\Fenrir\Gateway\Events\AutoModerationRuleCreate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::AUTO_MODERATION_RULE_CREATE, function (AutoModerationRuleCreate $event) {
    // Handle event
});
```
