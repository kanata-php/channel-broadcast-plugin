
# Channel Broadcast Kanata Plugin

This plugin implements channel broadcast. To work with it just need to copy this into `./content/plugins` and activate it via:

```shell
php kanata plugin:activate ChannelBroadcast
```

With this it will be possible to broadcast to channels with Socket Conveyor out of the box.

## Config

There is a `./config` directory with a configuration. There, for this version, you'll be able to set if you want a sample client UI to be in place in order for you to test this connection. The config is this: `channel-broadcast.sample-http`. This needs to be placed at the `./config/` of your kanata project if you want to use it, it won't work for the plugin's directory. You can publish this config with the command: 

```shell
php kanata plugin:publish ChannelBroadcast config
```

