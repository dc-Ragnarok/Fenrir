### Filtered event listener

Sometimes it may be useful to filter events coming in, such as when you're making a poll and want to listen to all incoming reactions for only one message.

For this, you can use `Ragnarok\Fenrir\FilteredEventListener`.
The `FilteredEventListener` has the ability to relay filtered events from the main `EventHandler` (though you can use anything that implements EventEmitterInterface).

The constructor takes 5 parameters,

1. `$eventEmitter`, this is the object which you'd like to filter events from. This would usually be `$discord->events`
2. `$event`, the event you'd like to filter
3. `$filter`, a `Closure` which serves as your filter
4. `$seconds`, the amount of seconds the filter should be active for (optional)
5. `$maxItems`, the amount of events you'd like to be emitted by the filter, this counts the amount of items that pass `$filter`

In the example below you can see a filtered listener is created for the `MESSAGE_REACTION_ADD` event. If the `!createListener` message receives a reaction within 20 seconds, it will announce what the reaction was in the channel. Note that this does not happen if the reaction is added to a different message.
