<?php

namespace LitePress\WP_China_Yes\Inc;

use LitePress\WP_China_Yes\Inc\Controller\Api\Coupon_Controller;
use LitePress\WP_China_Yes\Inc\Controller\Api\Order_Controller;
use LitePress\WP_China_Yes\Inc\Controller\Api\User_Controller;
use LitePress\WP_China_Yes\Inc\Controller\Web\Account_Controller;
use LitePress\WP_China_Yes\Inc\Controller\Web\Product_Controller;
use WP_REST_Server;

function store_web_route() {
    $product_controller = new Product_Controller();

    $route = 'plugins';
    if ( key_exists( 'subpage', $_GET ) ) {
        $route = sanitize_key( $_GET['subpage'] );
    }

    switch ( $route ) {
        case 'plugins':
            $product_controller->plugins();
            break;
        case 'themes':
            $product_controller->themes();
            break;
        case 'account':
            $account = new Account_Controller();
            $account->index();
            break;
        default:
            break;
    }
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'lp-api/v1', '/orders', array(
        'methods'             => WP_REST_Server::CREATABLE,
        'callback'            => [ Order_Controller::class, 'create' ],
        'permission_callback' => function () {
            return true;
        },
    ) );

    register_rest_route( 'lp-api/v1', '/orders/is_paid', array(
        'methods'  => WP_REST_Server::READABLE,
        'callback' => array( Order_Controller::class, 'is_paid' ),
    ) );

    register_rest_route( 'lp-api/v1', '/coupons', array(
        'methods'  => WP_REST_Server::READABLE,
        'callback' => array( Coupon_Controller::class, 'get' ),
    ) );

    register_rest_route( 'lp-api/v1', '/login', array(
        'methods'             => WP_REST_Server::CREATABLE,
        'callback'            => array( User_Controller::class, 'login' ),
        'permission_callback' => function () {
            return true;
        },
    ) );

    register_rest_route( 'lp-api/v1', '/logout', array(
        'methods'             => WP_REST_Server::CREATABLE,
        'callback'            => array( User_Controller::class, 'logout' ),
        'permission_callback' => function () {
            return true;
        },
    ) );
} );
