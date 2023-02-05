# DHP

A gateway/api wrapper for Discord.

## What is DHP

The goal of DHP is to provide a mostly plain wrapper over Discords APIs/gateway.
There will be no caching built in, this is for the user to implement themselves.

If you're looking for something thats easier to use, try [DiscordPHP](https://github.com/discord-php/DiscordPHP).

DHP heavily relies on ReactPHP for async operations. Knowing the basics of async PHP is recommended before diving in.

## Example bot

```php
use Exan\Dhp\Const\Events;
use Exan\Dhp\Discord;
use Exan\Dhp\Rest\Helpers\Channel\MessageBuilder;
use Exan\Dhp\Websocket\Events\MessageCreate;

require './vendor/autoload.php';

$discord = new Discord('TOKEN');

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
