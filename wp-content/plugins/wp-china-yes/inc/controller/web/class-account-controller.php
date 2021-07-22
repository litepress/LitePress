<?php

namespace LitePress\WP_China_Yes\Inc\Controller\Web;

use function LitePress\WP_China_Yes\Inc\get_template_part;
use const LitePress\WP_China_Yes\LPSTORE_BASE_URL;

final class Account_Controller {

    public function index() {
        $r    = wp_remote_get( LPSTORE_BASE_URL . 'account', array( 'timeout' => 10 )  );
        if ( is_wp_error( $r ) ) {
            echo $r->get_error_message();
            exit;
        }

        $body = json_decode( $r['body'] );

        $args = array(
            'apps'           => $body->data,
        );

        get_template_part( 'account', '', $args );
    }

}
