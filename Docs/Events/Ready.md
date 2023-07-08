#### Event
`READY`

#### Required Intents

#### Properties
|property|type|
|--------|----|
|`v`|`int`|
|`user`|`Ragnarok\Fenrir\Parts\User`|
|`session_id`|`string`|
|`resume_gateway_url`|`string`|
|`shard`|`array`|
|`application`|`Ragnarok\Fenrir\Parts\Application`|
|`t`|`null`&#124;`string`|
|`s`|`int`&#124;`null`|
|`op`|`int`|
|`d`|`any`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\Ready;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->on(Events::READY, function (Ready $event) {
    // Handle event
});
```
