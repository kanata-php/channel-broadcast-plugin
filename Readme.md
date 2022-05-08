
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

## Usage

With vanilla JS, the following sequence of commands will allow you to broadcast to the channel `test-channel`:

```javascript
let ws = new WebSocket('ws://127.0.0.1:8002');

ws.send(JSON.stringify({
    'action': 'channel-connect',
    'channel': 'test-channel',
}));

// this is how you message the channel:
ws.send(JSON.stringify({
    'action': 'channel-action', // this action is required!
    'data': 'My message',
}));
```

If you are using Socket Conveyor Client, the following snippet shows how you would connect to a channel to start receiving broadcasted messages, and to start to broadcast messages there:

At your client side, after having [Socket Conveyor Client](https://github.com/kanata-php/socket-conveyor-client) available, you can broadcast your first message after connection is ready like this:

```javascript
var websocket = new window.Conveyor({
    protocol: 'ws', // or 'wss' for ssl
    uri: '127.0.0.1',
    port: 8080,
    channel: 'test-channel',
    onMessage: (e) => console.log(e),
});

// this is how you message the channel:
websocket.send(
    'Message to channel',
    'channel-action' // this action is required!
);
```

You can test this by setting the config at `./config/channel-broadcast.php` to be like this `'sample-http' => true`. Once this is ready, once you start the http and websocket servers on Kanata, you'll be able to access the page `{url}/sample-ws-client`. Then you can access that page on the browser with multiple windows and see the magic happening.

## Hooks

### channel_message

Makes it possible for channel message processing before broadcasting.

2 parameters are passed:

- (array) `$data`, the current data being processed
- (?string) `$channel`, the current channel under execution.

Usage:

```php
add_filter('channel_message', function ($data, $channel) {
    return json_encode([$data, (new \DateTime)->getTimestamp()]);
}, 2);
```

This will convert the message into an array (json formatted) and add the timestamp to it.

The following message:

```javascript
ws.send(JSON.stringify({
    'action': 'channel-action', // this action is required!
    'data': 'My message',
}));
```

Would result on the following message broadcasted: `{action: "channel-action", data: "[\"My message\",1651973295]"}`.

### channel_message_valid

Makes it possible for channel validation customization.

3 parameters are passed:

- (bool) `$valid`, if the current execution is valid based on previous validations
- (array) `$data`, the current data being processed
- (?string) `$channel`, the current channel under execution.

Usage:

```php
add_filter('channel_message_valid', function ($valid, $data, $channel) {
    if ($data['data'] !== 'Hello' && $channel === 'test') {
        return false;
    }
    return $valid;
}, 3);
```

This will only allow the message "Hello" to the channel "test". Any other channel will accept any other message.
