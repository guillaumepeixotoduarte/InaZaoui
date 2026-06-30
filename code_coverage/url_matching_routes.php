<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/admin/album' => [[['_route' => 'admin_album_index', '_controller' => 'App\\Controller\\Admin\\AlbumController::index'], null, null, null, false, false, null]],
        '/admin/album/add' => [[['_route' => 'admin_album_add', '_controller' => 'App\\Controller\\Admin\\AlbumController::add'], null, null, null, false, false, null]],
        '/admin/media' => [[['_route' => 'admin_media_index', '_controller' => 'App\\Controller\\Admin\\MediaController::index'], null, null, null, false, false, null]],
        '/admin/media/add' => [[['_route' => 'admin_media_add', '_controller' => 'App\\Controller\\Admin\\MediaController::add'], null, null, null, false, false, null]],
        '/login' => [[['_route' => 'admin_login', '_controller' => 'App\\Controller\\Admin\\SecurityController::login'], null, null, null, false, false, null]],
        '/admin/invite' => [[['_route' => 'admin_user_index', '_controller' => 'App\\Controller\\Admin\\UserController::index'], null, null, null, false, false, null]],
        '/admin/invite/add' => [[['_route' => 'admin_user_add', '_controller' => 'App\\Controller\\Admin\\UserController::add'], null, null, null, false, false, null]],
        '/' => [[['_route' => 'home', '_controller' => 'App\\Controller\\HomeController::home'], null, null, null, false, false, null]],
        '/guests' => [[['_route' => 'guests', '_controller' => 'App\\Controller\\HomeController::guests'], null, null, null, false, false, null]],
        '/about' => [[['_route' => 'about', '_controller' => 'App\\Controller\\HomeController::about'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/admin/(?'
                    .'|album/(?'
                        .'|update/([^/]++)(*:41)'
                        .'|delete/([^/]++)(*:63)'
                    .')'
                    .'|media/delete/([^/]++)(*:92)'
                    .'|invite/(?'
                        .'|delete/([^/]++)(*:124)'
                        .'|switch_access/([^/]++)(*:154)'
                    .')'
                .')'
                .'|/guest/([^/]++)(*:179)'
                .'|/portfolio(?:/([^/]++))?(*:211)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        41 => [[['_route' => 'admin_album_update', '_controller' => 'App\\Controller\\Admin\\AlbumController::update'], ['id'], null, null, false, true, null]],
        63 => [[['_route' => 'admin_album_delete', '_controller' => 'App\\Controller\\Admin\\AlbumController::delete'], ['id'], null, null, false, true, null]],
        92 => [[['_route' => 'admin_media_delete', '_controller' => 'App\\Controller\\Admin\\MediaController::delete'], ['id'], null, null, false, true, null]],
        124 => [[['_route' => 'admin_user_delete', '_controller' => 'App\\Controller\\Admin\\UserController::delete'], ['id'], null, null, false, true, null]],
        154 => [[['_route' => 'admin_user_switch_access', '_controller' => 'App\\Controller\\Admin\\UserController::switchAccess'], ['id'], null, null, false, true, null]],
        179 => [[['_route' => 'guest', '_controller' => 'App\\Controller\\HomeController::guest'], ['id'], null, null, false, true, null]],
        211 => [
            [['_route' => 'portfolio', 'id' => null, '_controller' => 'App\\Controller\\HomeController::portfolio'], ['id'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
