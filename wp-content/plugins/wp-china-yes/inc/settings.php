<?php

namespace LitePress\WP_China_Yes\Inc;

add_action( 'admin_menu', function () {
    add_menu_page(
        '应用市场',
        '应用市场',
        is_multisite() ? 'manage_network_options' : 'manage_options',
        'lpstore',
        'LitePress\WP_China_Yes\Inc\store_web_route',
        'dashicons-cart',
        80
	);
} );

add_action( is_multisite() ? 'network_admin_menu' : 'admin_menu', function () {
    add_submenu_page(
        is_multisite() ? 'settings.php' : 'options-general.php',
        'WP-China-Yes',
        'WP-China-Yes',
        is_multisite() ? 'manage_network_options' : 'manage_options',
        'wp-china-yes',
        function () {
            require_once WCY_ROOT_PATH . 'template/settings.php';
        }
    );
} );
