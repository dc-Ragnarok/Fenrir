#### Event
`CHANNEL_CREATE`

#### Required Intents
- `GUILDS`

#### Properties
|property|type|
|--------|----|
|`id`|`string`|
|`type`|`Ragnarok\Fenrir\Enums\ChannelType`|
|`guild_id`|`null`&#124;`string`|
|`position`|`int`&#124;`null`|
|`permission_overwrites`|`array`&#124;`null`|
|`name`|`null`&#124;`string`|
|`topic`|`null`&#124;`string`|
|`nsfw`|`bool`&#124;`null`|
|`last_message_id`|`null`&#124;`string`|
|`bitrate`|`int`&#124;`null`|
|`user_limit`|`int`&#124;`null`|
|`rate_limit_per_user`|`int`&#124;`null`|
|`recipients`|`array`&#124;`null`|
|`icon`|`null`&#124;`string`|
|`owner_id`|`null`&#124;`string`|
|`application_id`|`null`&#124;`string`|
|`parent_id`|`null`&#124;`string`|
|`last_pin_timestamp`|`Carbon\Carbon`&#124;`null`|
|`rtc_region`|`null`&#124;`string`|
|`video_quality_mode`|`Ragnarok\Fenrir\Enums\VideoQualityMode`&#124;`null`|
|`message_count`|`int`&#124;`null`|
|`member_count`|`int`&#124;`null`|
|`thread_metadata`|`Ragnarok\Fenrir\Parts\ThreadMetadata`&#124;`null`|
|`member`|`Ragnarok\Fenrir\Parts\ThreadMember`&#124;`null`|
|`default_auto_archive_duration`|`int`&#124;`null`|
|`permissions`|`null`&#124;`string`|
|`flags`|`Ragnarok\Fenrir\Bitwise\Bitwise`&#124;`null`|
|`total_message_sent`|`int`&#124;`null`|
|`available_tags`|`array`&#124;`null`|
|`applied_tags`|`array`&#124;`null`|
|`default_reaction_emoji`|`Ragnarok\Fenrir\Parts\DefaultReaction`&#124;`null`|
|`default_thread_rate_limit_per_user`|`int`&#124;`null`|
|`default_sort_order`|`Ragnarok\Fenrir\Enums\SortOrderType`&#124;`null`|
|`default_forum_layout`|`Ragnarok\Fenrir\Enums\ForumLayoutType`&#124;`null`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\ChannelCreate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::CHANNEL_CREATE, function (ChannelCreate $event) {
    // Handle event
});
```
