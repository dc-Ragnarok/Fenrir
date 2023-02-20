<p align="center">
    <img src="./assets/logo.svg" height="150px">
</p>

<h3 align="center">Fenrir</h3>

<p align="center">A plain Discord API/Gateway wrapper in PHP.</p>

## Goal

The goal of Fenrir is to provide a mostly plain wrapper over Discords APIs/gateway.
There will be no caching built in, this is for the user to implement themselves.

If you're looking for something thats easier to use, try [DiscordPHP](https://github.com/discord-php/DiscordPHP).

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

## Contributing

Contributions are welcome.
You can look for `@todo` to find something that requires attention.
Please make sure to write tests where possible & make sure your code matches the phpcs configuration.
90% code coverage is required.
