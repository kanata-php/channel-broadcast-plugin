<?php

namespace ChannelBroadcast\Hooks;

use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Http
{
    public static function start()
    {
        if (is_http_execution()) {
            self::register_routes();
        }
    }

    public static function register_routes()
    {
        add_filter('routes', function($app) {
            $app->get('/sample-ws-client', function (Request $request, Response $response) {
                $template = plugin_path('channel-broadcast') . 'views/sample-client.html';
                $content = file_get_contents($template);
                if (!$content) {
                    throw new Exception('Template not found!');
                }
                $response->getBody()->write($content);
                return $response->withStatus(200);
            });
            return $app;
        });
    }
}