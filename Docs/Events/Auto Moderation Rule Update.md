#### Event
`AUTO_MODERATION_RULE_UPDATE`

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
use Ragnarok\Fenrir\Gateway\Events\AutoModerationRuleUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::AUTO_MODERATION_RULE_UPDATE, function (AutoModerationRuleUpdate $event) {
    // Handle event
});
```
