<?php
/**
 * 插件装载文件
 *
 * @package WP_China_Yes
 */

namespace LitePress\WP_China_Yes;

use LitePress\WP_China_Yes\Inc\Core;
use LitePress\WP_China_Yes\Inc\DataObject\Options;
use LitePress\WP_China_Yes\Inc\Plugin_Install;

/**
 * TODO 调试
 */
ini_set( 'display_errors', 1 );

require_once 'inc/data-object/class-user-info.php';
require_once 'inc/data-object/class-switch-status.php';
require_once 'inc/data-object/class-options.php';
require_once 'config.php';
require_once 'inc/functions.php';
require_once 'inc/class-core.php';
require_once 'inc/store-route.php';
require_once 'inc/settings.php';
require_once 'inc/enqueue-scripts.php';
require_once 'inc/controller/web/class-product-controller.php';
require_once 'inc/controller/web/class-account-controller.php';
require_once 'inc/controller/api/class-order-controller.php';
require_once 'inc/controller/api/class-coupon-controller.php';
require_once 'inc/controller/api/class-user-controller.php';
require_once 'inc/class-plugin-install.php';
require_once 'inc/data-object/class-product-type.php';

$wp_china_yes = Options::get_instance();

$core = Core::get_instance( $wp_china_yes );
$core->register_hook();

add_action( 'admin_init', function () {
    Plugin_Install::get_instance();
} );
