### Listening to raw events

While Finrir should cover most Events out of the box, you can also opt to listen to raw events, as they are emitted from Discord with minimal processing.

You can enable the emitting of raw events by passing the setting in the `option` param of the `Exan\Finrir\Discord` constructor.

You can then set a listener for these events using `Exan\Finrir\Const\Events::raw`. The handler receives a `Exan\Finrir\Websocket\Objects\Payload` as its only parameter.
