<?php

namespace LitePress\WP_China_Yes\Inc\Controller\Api;

use WP_REST_Request;
use WP_REST_Response;
use const LitePress\WP_China_Yes\LPSTORE_BASE_URL;

final class Order_Controller {

    static public function create( WP_REST_Request $request ): WP_REST_Response {
        global $wp_china_yes;

        $args = array(
            'timeout' => 10,
            'headers' => array(
                'Authorization' => 'Bearer ' . $wp_china_yes->get_user_info()->get_token(),
            ),
            'body'    => array(
                'product_id'  => $request->get_param( 'product_id' ),
                'coupon_code' => $request->get_param( 'coupon_code' ),
            ),
        );

        $r = wp_remote_post( LPSTORE_BASE_URL . 'orders', $args );
        if ( is_wp_error( $r ) ) {
            return new WP_REST_Response( array( 'code' => 500, 'message' => $r->get_error_message() ), 500 );
        }

        return new WP_REST_Response( json_decode( $r['body'] ) );
    }

    static public function is_paid( WP_REST_Request $request ): WP_REST_Response {
        global $wp_china_yes;

        $args = array(
            'timeout' => 10,
            'headers' => array(
                'Authorization' => 'Bearer ' . $wp_china_yes->get_user_info()->get_token(),
            ),
        );

        $r = wp_remote_get( LPSTORE_BASE_URL . 'orders/' . $request->get_param( 'order_id' ) . '/is_paid', $args );
        if ( is_wp_error( $r ) ) {
            return new WP_REST_Response( array( 'code' => 500, 'message' => $r->get_error_message() ), 500 );
        }

        return new WP_REST_Response( json_decode( $r['body'] ) );
    }

}
