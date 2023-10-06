#### Event
`GUILD_UPDATE`

#### Required Intents
- `GUILDS`

#### Properties
|property|type|
|--------|----|
|`id`|`string`|
|`name`|`string`|
|`icon`|`null`&#124;`string`|
|`icon_hash`|`null`&#124;`string`|
|`splash`|`null`&#124;`string`|
|`discovery_splash`|`null`&#124;`string`|
|`owner`|`bool`&#124;`null`|
|`owner_id`|`string`|
|`permissions`|`null`&#124;`string`|
|`region`|`null`&#124;`string`|
|`afk_channel_id`|`null`&#124;`string`|
|`afk_timeout`|`int`|
|`widget_enabled`|`bool`|
|`widget_channel_id`|`null`&#124;`string`|
|`verification_level`|`Ragnarok\Fenrir\Enums\VerificationLevel`|
|`default_message_notifications`|`Ragnarok\Fenrir\Enums\MessageNotificationLevel`|
|`explicit_content_filter`|`Ragnarok\Fenrir\Enums\ExplicitContentFilterLevel`|
|`roles`|`array`|
|`emojis`|`array`|
|`features`|`array`|
|`mfa_level`|`Ragnarok\Fenrir\Enums\MfaLevel`|
|`application_id`|`null`&#124;`string`|
|`system_channel_id`|`null`&#124;`string`|
|`system_channel_flags`|`Ragnarok\Fenrir\Bitwise\Bitwise`|
|`rules_channel_id`|`null`&#124;`string`|
|`max_presences`|`int`&#124;`null`|
|`max_members`|`int`&#124;`null`|
|`vanity_url_code`|`null`&#124;`string`|
|`description`|`null`&#124;`string`|
|`banner`|`null`&#124;`string`|
|`premium_tier`|`Ragnarok\Fenrir\Enums\PremiumTier`|
|`premium_subscription_count`|`int`&#124;`null`|
|`preferred_locale`|`string`|
|`public_updates_channel_id`|`null`&#124;`string`|
|`max_video_channel_users`|`int`&#124;`null`|
|`approximate_member_count`|`int`&#124;`null`|
|`approximate_presence_count`|`int`&#124;`null`|
|`welcome_screen`|`Ragnarok\Fenrir\Parts\WelcomeScreen`&#124;`null`|
|`nsfw_level`|`Ragnarok\Fenrir\Enums\NsfwLevel`|
|`stickers`|`array`&#124;`null`|
|`premium_progress_bar_enabled`|`bool`|
|`safety_alerts_channel_id`|`null`&#124;`string`|

#### Listener
```php
use Ragnarok\Fenrir\Gateway\Events\GuildUpdate;
use Ragnarok\Fenrir\Constants\Events;

$discord->gateway->events->on(Events::GUILD_UPDATE, function (GuildUpdate $event) {
    // Handle event
});
```
