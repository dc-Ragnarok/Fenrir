### Listening to raw events

While Fenrir should cover most Events out of the box, you can also opt to listen to raw events, as they are emitted from Discord with minimal processing.

These raw events are also used internally, unless you have vast knowledge of Discords Gateway and Fenrirs internal workings, you should probably refrain from modifying the payload itself.

In order to improve testability of Gateway logic, raw events make use of [Eventer](https://github.com/rxak-php/Eventer) rather than [Événement](https://github.com/igorw/evenement) like the more public-facing events.

In order to listen to an event, you need to register a listener class that implements `EventInterface`. Inside the constructor of the event class, you have access to a `ConnectionInterface`, `Payload`, and `LoggerInterface`.

You can register your listener using `$discord->gateway->raw->register(Listener::class)`
