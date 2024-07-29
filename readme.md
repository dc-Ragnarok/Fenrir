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

If you're looking for something thats easier to use, has caching OOTB, you could consider [DiscordPHP](https://github.com/discord-php/DiscordPHP).

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

## REST-only example

```php
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Rest\Helpers\Channel\MessageBuilder;

require './vendor/autoload.php';

$discord = new Discord('TOKEN');
$discord->withRest();

$discord->rest->channel->createMessage(
    'channel-id',
    (new MessageBuilder())
        ->setContent('Hi there!')
);
```
(Note: going with REST-only means you do NOT receive any events and your bot will appear offline)

For more examples, check out the examples directory

## Support

Fenrir currently supports PHP 8.1 to 8.3.
Tests should pass nightly 8.4 builds, but this is not a supported usecase.

If you're using this in a Apache2/Nginx/etc webserver environment, you should probably limit yourself to only using Fenrir's REST capabilities.
These environments typically don't allow long-running processes.

32-bit is not supported, though no hard limit is in place.

## Contributing

Contributions are welcome.
You can look for `@todo` to find something that requires attention.
Please make sure to write tests where possible & make sure your code matches the phpcs configuration.
Thanks!

## Notice

The current underlying HTTP component is subject to change in the future.
While the accesible API for it will remain similar, you should try to refrain from using it manually in your application.
