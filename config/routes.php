<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Attachments',
    ['path' => '/'],
    function (RouteBuilder $routes) {
        $routes->prefix('admin', function (RouteBuilder $routes) {
            $routes->scope('/attachments', [], function (RouteBuilder $routes) {
                $routes->fallbacks();
            });
        });
    }
);
