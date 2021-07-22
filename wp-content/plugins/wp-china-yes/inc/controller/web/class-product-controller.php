<?php

namespace LitePress\WP_China_Yes\Inc\Controller\Web;

use LitePress\WP_China_Yes\Inc\DataObject\Product_Type;
use function LitePress\WP_China_Yes\Inc\get_products_from_lpcn;
use function LitePress\WP_China_Yes\Inc\get_template_part;

final class Product_Controller {

    public function plugins() {
        $body = get_products_from_lpcn( Product_Type::Plugin );

        $all_local_active_projects = get_option( 'active_plugins' );
        $all_local_projects        = array();
        foreach ( get_plugins() as $key => $item ) {
            if ( in_array( $key, $all_local_active_projects ) ) {
                $item['Status'] = 'Activated';
            } else {
                $item['Status'] = 'Deactivated';
            }

            $item['Plugin'] = $key;

            $all_local_projects[ $item['TextDomain'] ] = $item;
        }

        $args = array(
            'projects'           => $body->data,
            'all_local_projects' => $all_local_projects,
            'cats'               => $body->cats,
            'total'              => $body->total,
            'totalpages'         => $body->totalpages,
            'paged'              => $_GET['paged'] ?? 1,
        );

        get_template_part( 'plugins', '', $args );
    }

    public function themes() {
        $body = get_products_from_lpcn( Product_Type::Theme );

        $args = array(
            'projects'             => $body->data,
            'all_local_projects'   => wp_get_themes(),
            'local_active_project' => wp_get_theme()->get_stylesheet(),
            'cats'                 => $body->cats,
            'total'                => $body->total,
            'totalpages'           => $body->totalpages,
            'paged'                => $_GET['paged'] ?? 1,
        );

        get_template_part( 'themes', '', $args );
    }

}
