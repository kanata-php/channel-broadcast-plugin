<?php

namespace ChannelBroadcast\Hooks;

use ChannelBroadcast\Actions\ChannelAction;
use Conveyor\Actions\ChannelConnectAction;
use Conveyor\Actions\ChannelDisconnectAction;

class WebSocket
{
    public static function start()
    {
        if (is_websocket_execution()) {
            self::register_socket_actions();
        }
    }

    private static function register_socket_actions()
    {
        add_filter('socket_actions', function($socketRouter) {
            $socketRouter->add(new ChannelConnectAction);
            $socketRouter->add(new ChannelDisconnectAction);
            $socketRouter->add(new ChannelAction);
            return $socketRouter;
        }, 2);
    }
}