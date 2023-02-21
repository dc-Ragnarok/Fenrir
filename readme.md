<p align="center">
    <img src="./assets/logo.svg" height="150px">
</p>

<h3 align="center">Fenrir</h3>

<p align="center">A plain Discord API/Gateway wrapper in PHP.</p>

## About

Fenrir is a mostly plain wrapper over Discords APIs/gateway.
There is no caching built in, this is for the user to implement themselves.

If you're looking for something thats easier to use, has caching OOTB, try [DiscordPHP](https://github.com/discord-php/DiscordPHP).

Fenrir heavily relies on ReactPHP for async operations. Knowing the basics of async PHP is recommended before diving in.

## Example bot

```php
use Exan\Fenrir\Bitwise\Bitwise;
use Exan\Fenrir\Const\Events;
use Exan\Fenrir\Discord;
use Exan\Fenrir\Enums\Gateway\Intents;
use Exan\Fenrir\Rest\Helpers\Channel\MessageBuilder;
use Exan\Fenrir\Websocket\Events\MessageCreate;

require './vendor/autoload.php';

$discord = new Discord(
    'TOKEN',
    Bitwise::from(
        Intents::GUILD_MESSAGES,
        Intents::DIRECT_MESSAGES,
        Intents::MESSAGE_CONTENT,
    )
);

$discord->events->on(Events::MESSAGE_CREATE, function (MessageCreate $message) use ($discord) {
    if ($message->content === '!ping') {
        $discord->rest->channel->createMessage(
            $message->channel_id,
            (new MessageBuilder())
                ->setContent('pong!')
        );
    }
});

$discord->connect(); // Nothing after this line is executed
```

For more examples, check out the examples directory (todo)

## Support

Fenrir currently supports PHP 8.1 & PHP 8.2.
Tests should pass nightly 8.3 builds, but this is not a supported usecase.

You should not be using this library on an Apache2/Nginx/etc webserver.
While there is nothing stopping you from using it on such environments, you should know what you're doing & limit yourself to only use Fenrir's REST capabilities.

If you're using a 32-bit system, you should use the `ext-gmp` extension.
Supporting 32-bit systems is a low priority.
If possible, using 64-bit is recommended.

## Contributing

Contributions are welcome.
You can look for `@todo` to find something that requires attention.
Please make sure to write tests where possible & make sure your code matches the phpcs configuration.
90% code coverage is required.
