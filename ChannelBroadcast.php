<?php

use ChannelBroadcast\Hooks;
use Kanata\Interfaces\KanataPluginInterface;
use Psr\Container\ContainerInterface;
use Kanata\Annotations\Plugin;
use Kanata\Annotations\Description;
use Kanata\Annotations\Author;

/**
 * @Plugin(name="ChannelBroadcast")
 * @Description(value="Plugin for basic WS Channel Broadcast")
 * @Author(name="Savio Resende",email="savio@savioresende.com.br")
 */

class ChannelBroadcast implements KanataPluginInterface
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return void
     */
    public function start(): void
    {
        Hooks\WebSocket::start();

        if (config('channel-broadcast.sample-http', false)) {
            Hooks\Http::start();
        }
    }
}
