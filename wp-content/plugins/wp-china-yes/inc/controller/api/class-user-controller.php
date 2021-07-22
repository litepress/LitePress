<?php

namespace LitePress\WP_China_Yes\Inc\Controller\Api;

use LitePress\WP_China_Yes\Inc\DataObject\User_Info;
use WP_REST_Request;
use WP_REST_Response;
use const LitePress\WP_China_Yes\LPSTORE_BASE_URL;

final class User_Controller {

    static public function login( WP_REST_Request $request ): WP_REST_Response {
        global $wp_china_yes;

        $args = array(
            'timeout' => 10,
            'body'    => array(
                'username' => $request->get_param( 'user_login' ),
                'password' => $request->get_param( 'password' ),
            ),
        );

        $r = wp_remote_post( LPSTORE_BASE_URL . 'user-auth/login', $args );
        if ( is_wp_error( $r ) ) {
            return new WP_REST_Response( array( 'code' => 500, 'message' => $r->get_error_message() ), 500 );
        }

        $body = json_decode( $r['body'] );

        if ( isset( $body->code ) ) {
            // 如果接口回传了code字段代表出错了
            return new WP_REST_Response( array( 'code' => 403, 'message' => '账户或密码不正确' ), 403 );
        }

        $user_info = new User_Info();
        $user_info->set_token( $body->token )
                  ->set_user_email( $body->user_email )
                  ->set_user_nicename( $body->user_nicename )
                  ->set_user_display_name( $body->user_display_name );

        $wp_china_yes->set_user_info( $user_info )
                     ->save();

        return new WP_REST_Response( array( 'code' => 200, 'message' => '登录成功' ) );
    }

    static public function logout(): WP_REST_Response {
        global $wp_china_yes;

        $wp_china_yes->set_user_info( new User_Info() );
        $wp_china_yes->save();

        return new WP_REST_Response( array( 'code' => 200, 'message' => 'OK' ) );
    }

}
