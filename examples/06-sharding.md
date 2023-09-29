### Filtered event listener

Bigger bots will require to use sharding. With sharding, you can split up the amount of Guilds a process handles, making it possible to scale your bot horizontally.

For this, you can use `Ragnarok\Fenrir\Gateway\Shard`.

The constructor takes 2 parameters,

1. `$shardId`, the shard the current process will control
2. `$numShards`, the total amount of shards

You can then pass this `Shard` instance along to the gateway connection. `$discord->gateway->shard($shard)`.

Note that this method takes an instance of `Ragnarok\Fenrir\Gateway\ShardInterface`. If you need additional logic in order to prepare the shard array for the identify payload, you can create your own implementation for it.

Refer to the [Discord developer documentation](https://discord.com/developers/docs/topics/gateway#sharding) for more info on sharding.
