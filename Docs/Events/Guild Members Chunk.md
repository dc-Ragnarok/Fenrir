#### Event
`GUILD_MEMBERS_CHUNK`

#### Required Intents

#### Properties
|property|type|
|--------|----|
|`guild_id`|`string`|
|`members`|`array`|
|`chunk_index`|`int`|
|`chunk_count`|`int`|
|`not_found`|`array`|
|`presences`|`array`|
|`nonce`|`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildMembersChunk;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::GUILD_MEMBERS_CHUNK, function (GuildMembersChunk $event) {
    // Handle event
});
```
