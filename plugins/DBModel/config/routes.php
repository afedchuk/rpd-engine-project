<?php
use Cake\Routing\Router;

Router::plugin(
    'DBModel',
    ['path' => '/d-b-model'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
