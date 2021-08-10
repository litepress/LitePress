<?php
/**
 * Plugin Name: LitePress 框架
 * Description: LitePress系列插件所需要的公共组件（基于Codestar Framework）
 * Author: 老孙穿女装
 * Author URI: https://litepress.cn/user/jerry/
 * Version: 2.2.4
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace LitePress\Framework;

if ( ! defined( 'ABSPATH' ) ) { die; } // 禁止随意访问

// 载入插件装载文件
require_once 'classes/setup.class.php';

// 设置前缀
$prefix = 'litepress';

// 创建菜单
Framework::createOptions( $prefix, array(
  'menu_title' => 'LitePress',
  'menu_slug'  => 'litepress',
) );
