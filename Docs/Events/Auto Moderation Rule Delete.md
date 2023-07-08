#### Event
`AUTO_MODERATION_RULE_DELETE`

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
use Ragnarok\Fenrir\Gateway\Events\AutoModerationRuleDelete;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::AUTO_MODERATION_RULE_DELETE, function (AutoModerationRuleDelete $event) {
    // Handle event
});
```
