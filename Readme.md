
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

If you are using Socket Conveyor Client, the following snippet shows how you would connect to a channel to start receiving broadcasted messages, and to start to broadcast messages there:

At your client side, after having Socket Conveyor Client available, you can broadcast your first message after connection is ready like this:

```html
<div>
    <div>
        <button onClick="sendMessage('example-first-action-message', 'example-first-action')">First Action</button>
    </div>
    <div>
        <button onClick="sendMessage('example-second-action-message')">Second Action</button>
    </div>
    <div id="output"></div>
</div>
<script src="/js/app.js"></script>
<script type="text/javascript">
    var actionChannel = 'channel-action';
    var websocket = new window.Conveyor({
        channel: 'test-channel',
        onReady: (e) => {
            sendMessage('Initial Message');
        },
        onMessage: (e) => {
            document.getElementById('output').innerHTML = e;
        },
    });

    function sendMessage(message, action) {
        if (typeof action === 'undefined') {
            action = actionChannel;
        }

        websocket.send(message, action);
    }
</script>
```

You can test this by setting the config at `./config/channel-broadcast.php` to be like this `'sample-http' => true`. Once this is ready, once you start the http and websocket servers on Kanata, you'll be able to access the page `{url}/sample-ws-client`. Then you can access that page on the browser with multiple windows and see the magic happening.