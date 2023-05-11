<?php

$routes = [
    'home' => [
        'path' => '/',
        'controller' => 'HomeController',
        'method' => 'index'
    ],
    'comments' => [
        'path' => '/comments',
        'controller' => 'CommentsController',
        'method' => 'index'
    ],

    'signup' => [
        'path' => '/signup',
        'controller' => 'UserController',
        'method' => 'signup'
    ],
    'login' => [
        'path' => '/login',
        'controller' => 'AuthController',
        'method' => 'login'
    ],
    'logout' => [
        'path' => '/logout',
        'controller' => 'AuthController',
        'method' => 'logout'
    ],
    'adminLogin' => [
        'path' => '/adminLogin',
        'controller' => 'Admin\\AdminLoginController',
        'method' => 'index'
    ],
    'adminMenu' => [
        'path' => '/adminMenu',
        'controller' => 'Admin\\AdminMenuController',
        'method' => 'index'
    ],
    'mentionsLegales' => [
        'path' => '/mentionsLegales',
        'controller' => 'MentionsLegalesController',
        'method' => 'index'
    ]

];

return $routes;
