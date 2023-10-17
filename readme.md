<p align="center">
    <img src="./assets/logo.svg" height="150px">
</p>

<h3 align="center">Fenrir</h3>

<p align="center">PHP Discord Interface.</p>

<div align="center">

[![Fenrir Code Quality](https://github.com/dc-Ragnarok/Fenrir/actions/workflows/code-quality.yml/badge.svg)](https://github.com/dc-Ragnarok/Fenrir/actions/workflows/code-quality.yml)
[![Fenrir Unit Tests](https://github.com/dc-Ragnarok/Fenrir/actions/workflows/unit-tests.yml/badge.svg)](https://github.com/dc-Ragnarok/Fenrir/actions/workflows/unit-tests.yml)

</div>

## About

Fenrir is a mostly plain wrapper over Discords APIs/gateway.
There is no caching built in, this is for the user to implement themselves.

If you're looking for something thats easier to use, has caching OOTB, try [DiscordPHP](https://github.com/discord-php/DiscordPHP).

Fenrir heavily relies on ReactPHP for async operations. Knowing the basics of async PHP is recommended before diving in.

## Example bot

```php
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Gateway\Events\MessageCreate;
use Ragnarok\Fenrir\Rest\Helpers\Channel\MessageBuilder;

require './vendor/autoload.php';

$discord = new Discord('TOKEN');

$discord
    ->withGateway(Bitwise::from(
        Intent::GUILD_MESSAGES,
        Intent::DIRECT_MESSAGES,
        Intent::MESSAGE_CONTENT,
    ))
    ->withRest();

$discord->gateway->events->on(Events::MESSAGE_CREATE, function (MessageCreate $message) use ($discord) {
    if ($message->content === '!ping') {
        $discord->rest->channel->createMessage(
            $message->channel_id,
            (new MessageBuilder())
                ->setContent('pong!')
        );
    }
});

$discord->gateway->open(); // Nothing after this line is executed
```

For more examples, check out the examples directory (todo)

## Support

Fenrir currently supports PHP 8.1 & PHP 8.2.
Tests should pass nightly 8.3 builds, but this is not a supported usecase.

You should not be using this library on an Apache2/Nginx/etc webserver.
While there is nothing stopping you from using it on such environments, you should know what you're doing & limit yourself to only use Fenrir's REST capabilities.

32-bit is not supported, though no hard limit is in place.

## Contributing

Contributions are welcome.
You can look for `@todo` to find something that requires attention.
Please make sure to write tests where possible & make sure your code matches the phpcs configuration.
Thanks!

## Notice

The current underlying HTTP component is subject to change in the future.
While the accesible API for it will remain similar, you should try to refrain from using it manually in your application.

##### Jetbrains oss license
Thanks to Jetbrains for providing an [OSS license](https://www.jetbrains.com/community/opensource/#support) for this project!
