<?php
/**
 * Plugin Name: LitePress Beta
 * Description: 启用此插件以参加LitePress Beta版本测试
 * Author: 老孙穿女装
 * Author URI: https://litepress.cn/user/jerry/
 * Version: 2.2.0
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace LitePress\Beta;

function lp_filter_http_request( $result, $args, $url ) {
		
		// 不是版本更新的查询请求，直接返回
		if ( false === strpos( $url, '//api.w.org.ibadboy.net/core/version-check/' ) && false === strpos( $url, '//api.wordpress.org/core/version-check/' ) ) {
			return $result;
		}

		// 是版本更新的查询的话
		$args['_beta_tester'] = true;
        $url = str_replace('//api.w.org.ibadboy.net', '//beta.litepress.cn', $url);
        $url = str_replace('//api.wordpress.org', '//beta.litepress.cn', $url);

		return wp_remote_get( $url, $args );
}
add_filter( 'pre_http_request', '\LitePress\Beta\lp_filter_http_request', 10, 3 );
