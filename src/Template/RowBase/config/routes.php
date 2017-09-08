<?php
// pageで使用するので記載をしておく
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\InflectedRoute;

Router::defaultRouteClass(InflectedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Tops', 'action' => 'index']);

    // 管理者のRoutes設定
    Router::prefix('admin', function ($routes) {
        $routes->connect('/', ['controller' => 'Tops', 'action' => 'index']);
        $routes->connect('/:controller', [], ['routeClass' => 'InflectedRoute']);
        $routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);

        $routes->extensions(['json']);
        $routes->fallbacks();
    });

    $routes->fallbacks();
});

Plugin::routes();
