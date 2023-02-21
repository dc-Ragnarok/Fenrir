### Async in order

Sometimes you may need to execute several async actions in order.
This can be accomplished using (among others) a recursive anonymous.

This example shows how to send several messages in order, you can also abstract this further to an array of anonymous functions returning a promise, which you can then use everywhere.
