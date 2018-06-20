<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Assets',
    ['path' => '/'],
    function (RouteBuilder $routes) {
        $routes->scope('/assets', [], function (RouteBuilder $routes) {
            $routes->fallbacks();
        });

        $routes->prefix('admin', function (RouteBuilder $routes) {
            $routes->scope('/assets', [], function (RouteBuilder $routes) {
                $routes->fallbacks();
            });
        });
    }
);
