### Listening to raw events

While Fenrir should cover most Events out of the box, you can also opt to listen to raw events, as they are emitted from Discord with minimal processing.

You can enable the emitting of raw events by passing the setting in the `option` param of the `Exan\Fenrir\Discord` constructor.

You can then set a listener for these events using `Exan\Fenrir\Constants\Events::raw`. The handler receives a `Exan\Fenrir\Websocket\Objects\Payload` as its only parameter.
