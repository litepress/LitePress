<?php

namespace LitePress\WP_China_Yes\Inc;

use LitePress\WP_China_Yes\Inc\DataObject\Product_Type;
use LitePress\WP_China_Yes\Inc\DataObject\Switch_Status;
use const LitePress\WP_China_Yes\LPSTORE_BASE_URL;

function get_curl_version() {
    $curl_version = '1.0.0';

    if ( function_exists( 'curl_version' ) ) {
        $curl_version_array = curl_version();
        if ( is_array( $curl_version_array ) && key_exists( 'version', $curl_version_array ) ) {
            $curl_version = $curl_version_array['version'];
        }
    }

    return $curl_version;
}

function replace_page_str( $replace_func, $param ) {
    ob_start( function ( $buffer ) use ( $replace_func, $param ) {
        $param[] = $buffer;

        return call_user_func_array( $replace_func, $param );
    } );
}

/**
 * 计算时间差并将计算结果转换为时、分、秒的形式
 *
 * @param $date1
 * @param $date2
 *
 * @return int[]
 */
function diff_date( $date1, $date2 ) {
    $start = strtotime( $date1 );
    $end   = strtotime( $date2 );
    if ( $start > $end ) {
        $diff_time = $start - $end;
    } else {
        $diff_time = $end - $start;
    }

    $year_t   = 3600 * 24 * 365;
    $month_t  = 3600 * 24 * 30;
    $week_t   = 3600 * 24 * 7;
    $day_t    = 3600 * 24;
    $hours_t  = 3600;
    $minute_t = 60;

    $year    = floor( $diff_time / $year_t );
    $month   = floor( ( $diff_time - $year * $year_t ) / $month_t );
    $week    = floor( ( $diff_time - ( $year * $year_t ) - ( $month * $month_t ) ) / $week_t );
    $days    = floor( ( $diff_time - ( $year * $year_t ) - ( $month * $month_t ) - ( $week * $week_t ) ) / $day_t );
    $hours   = floor( ( $diff_time - ( $year * $year_t ) - ( $month * $month_t ) - ( $week * $week_t ) - ( $days * $day_t ) ) / $hours_t );
    $minute  = floor( ( $diff_time - ( $year * $year_t ) - ( $month * $month_t ) - ( $week * $week_t ) - ( $days * $day_t ) - $hours * $hours_t ) / $minute_t );
    $seconds = $diff_time - ( $year * $year_t ) - ( $month * $month_t ) - ( $week * $week_t ) - ( $days * $day_t ) - ( $hours * $hours_t ) - ( $minute * $minute_t );

    return array(
        '年'  => (int) $year,
        '月'  => (int) $month,
        '天'  => (int) $days,
        '小时' => (int) $hours,
        '分钟' => (int) $minute,
        '秒'  => (int) $seconds
    );
}

/**
 * 读取给定时间距离当前时间的插值
 *
 * @param int $timestamp 要和当前时间对比的时间戳
 *
 * @return string 返回相差的时间，例如：1分钟前、1小时前、一天前
 */
function get_how_ago( $timestamp ) {
    $diff_time = '';
    foreach ( (array) diff_date( current_time( 'Y-m-d H:i:s' ), date( 'Y-m-d H:i:s', $timestamp ) ) as $key => $value ) {
        if ( 0 !== $value ) {
            $diff_time = $value . $key . '前';
            break;
        }
    }

    return $diff_time;
}

/**
 * 格式化作品已安装数量
 *
 * 对应小于10000的作品直接返回原数字接一个加号，对于大于等于10000的，转换为汉字显示。
 *
 * @param int $num
 *
 * @return string
 */
function prepare_installed_num( $num ) {
    $str    = $num;
    $length = strlen( $num );
    if ( $length > 8 ) { //亿单位
        $str = str_replace( '00000000', '', $num ) . '亿';
    } elseif ( $length > 4 ) { //万单位
        $str = str_replace( '0000', '', $num ) . '万';
    }

    return $str . '+';
}

/**
 * 格式化远端API返回的Metas
 *
 * API返回的Meta是以数组形式组织的，不便于索引，通过该函数将其转化为key => value模式
 */
function prepare_meta( $metas ) {
    $data = array();
    foreach ( (array) $metas as $meta ) {
        $data[ $meta->key ] = $meta->value;
    }

    return $data;
}

/**
 * 输出分页条
 */
function pagination( $total, $totalpages, $paged ) {
    $first_page = add_query_arg( array( 'paged' => 1 ) );
    $last_page  = add_query_arg( array( 'paged' => $totalpages ) );
    $prev_page  = add_query_arg( array( 'paged' => $paged > 1 ? $paged - 1 : 1 ) );
    $next_page  = add_query_arg( array( 'paged' => $paged < $totalpages ? $paged + 1 : $totalpages ) );

    echo '<div class="tablenav-pages"><span class="displaying-num">共' . $total . '个项目</span><span class="pagination-links">';

    if ( $paged > 1 ) {
        echo <<<html
<a class="first-page button" href="{$first_page}">
  <span class="screen-reader-text">首页</span><span aria-hidden="true">«</span>
</a> 
html;

        echo <<<html
<a class="prev-page button" href="{$prev_page}">
  <span class="screen-reader-text">上一页</span><span aria-hidden="true">‹</span>
</a> 
html;
    } else {
        echo <<<html
<span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span> 
html;

        echo <<<html
<span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span> 
html;
    }

    echo <<<html
<span class="paging-input">
    第<label for="current-page-selector" class="screen-reader-text">当前页</label>
    <input class="current-page" id="current-page-selector" type="text" name="paged" value="{$paged}" size="4" aria-describedby="table-paging">
    <span class="tablenav-paging-text">页，共<span class="total-pages">{$totalpages}</span>页</span>
</span> 
html;

    if ( $paged < $totalpages ) {
        echo <<<html
<a class="next-page button" href="{$next_page}">
  <span class="screen-reader-text">下一页</span><span aria-hidden="true">›</span>
</a> 
html;

        echo <<<html
<a class="last-page button" href="{$last_page}">
  <span class="screen-reader-text">尾页</span><span aria-hidden="true">»</span>
</a> 
html;
    } else {
        echo <<<html
<span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span> 
html;

        echo <<<html
<span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span> 
html;
    }

    echo '</span></div>';
}

/**
 * 检查给定的状态值是否符合当前设置状态
 *
 * @param $value string 给定的状态值
 *
 * @return bool 如果状态值与当前状态符合则返回true，比如说给定状态值是Switch_Status::ONLY_USER而当前正好处在用户前端就会返回true
 */
function check_switch_status( $value ) {
    if ( Switch_Status::OFF === $value ) {
        return false;
    } elseif ( Switch_Status::ONLY_USER === $value && is_admin() ) {
        return false;
    } elseif ( Switch_Status::ONLY_ADMIN === $value && ! is_admin() ) {
        return false;
    }

    return true;
}

/**
 * 输出开关HTML
 *
 * @param string $name
 * @param string $value
 * @param string $type
 */
function get_switch( string $name, string $value, string $type = 'advanced' ) {
    global $wp_china_yes;
    ?>
  <select class="regular" name="wp-china-yes[<?php echo $name; ?>]" id="wp-china-yes[<?php echo $name; ?>]">
      <?php if ( 'advanced' === $type ): ?>
        <option value="<?php echo $wp_china_yes::ONLY_USER; ?>" <?php selected( $value, $wp_china_yes::ONLY_USER ); ?>>
          前台开启
        </option>
        <option value="<?php echo $wp_china_yes::ONLY_ADMIN; ?>" <?php selected( $value, $wp_china_yes::ONLY_ADMIN ); ?>>
          后台开启
        </option>
      <?php endif; ?>
    <option value="<?php echo $wp_china_yes::ON; ?>" <?php selected( $value, $wp_china_yes::ON ); ?>><?php echo 'advanced' === $type ? '全局开启' : '启用' ?></option>
    <option value="<?php echo $wp_china_yes::OFF; ?>" <?php selected( $value, $wp_china_yes::OFF ); ?>>禁用</option>
  </select>
    <?php
}

/**
 * 获取模板
 */
function get_template_part( string $slug, string $name = '', array $tpl_args = array() ) {
    if ( empty( $name ) ) {
        require WCY_ROOT_PATH . "template/{$slug}.php";
    } else {
        require WCY_ROOT_PATH . "template/{$slug}-{$name}.php";
    }
}

/**
 * 获取产品价格的HTML
 */
function prepare_price_for_html( int $price, bool $echo = true ): string {
    $html = '';
    if ( empty( $price ) || 0 === $price ) {
        $html .= '  <span class="woocommerce-Price-amount free">
  <bdi>
    
    <b class="total_price">免费</b>
  </bdi>
</span>                 ';
    } else {
        $html .= <<<html
<span class="woocommerce-Price-amount amount">
  <bdi>
    <span class="woocommerce-Price-currencySymbol">¥</span>
    <b class="total_price">{$price}</b>
  </bdi>
</span>
html;
    }

    if ( $echo ) {
        echo $html;
    }

    return $html;
}

function get_products_from_lpcn( string $product_type ) {
    $paged = absint( isset( $_GET['paged'] ) && $_GET['paged'] > 0 ? $_GET['paged'] : 1 );

    $category = $_GET['sub_cat'] ?? '';
    if ( empty( $category ) ) {
        $category = Product_Type::Plugin === $product_type ? '15' : '17';
    }

    $args = array(
        'type'     => $product_type,
        'page'     => $paged,
        'category' => $category,
        'order'    => $_GET['order'] ?? 'desc',
        'orderby'  => $_GET['orderby'] ?? 'popularity',
    );

    if ( isset( $_GET['min_price'] ) ) {
        $args['min_price'] = $_GET['min_price'];
    }

    if ( isset( $_GET['max_price'] ) ) {
        $args['max_price'] = $_GET['max_price'];
    }

    if ( isset( $_GET['search'] ) ) {
        $args['search'] = $_GET['search'];
    }

    if ( isset( $_GET['search_by'] ) ) {
        $args['search_by'] = $_GET['search_by'];
    }

    $r = wp_remote_get( add_query_arg( $args, LPSTORE_BASE_URL . 'products' ), array( 'timeout' => 10 ) );
    if ( is_wp_error( $r ) ) {
        echo $r->get_error_message();
        exit;
    }

    return json_decode( $r['body'] );
}
