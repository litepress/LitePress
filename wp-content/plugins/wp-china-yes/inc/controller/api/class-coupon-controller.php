<?php

namespace LitePress\WP_China_Yes\Inc\Controller\Api;

use WP_REST_Request;
use WP_REST_Response;
use const LitePress\WP_China_Yes\LPSTORE_BASE_URL;

final class Coupon_Controller {

    static public function get( WP_REST_Request $request ) {
        global $wp_china_yes;

        $args = array(
            'timeout' => 10,
            'headers' => array(
                'Authorization' => 'Bearer ' . $wp_china_yes->get_user_info()->get_token(),
            ),
        );

        $r = wp_remote_get( LPSTORE_BASE_URL . 'coupons/' . $request->get_param( 'code' ), $args );
        if ( is_wp_error( $r ) ) {
            return new WP_REST_Response( array( 'code' => 500, 'message' => $r->get_error_message() ), 500 );
        }

        return new WP_REST_Response( json_decode( $r['body'] ) );
    }

}
