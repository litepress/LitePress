<?php

namespace LitePress\WP_China_Yes\Inc\DataObject;

final class Switch_Status {

    const ONLY_USER = 'only-user';

    const ONLY_ADMIN = 'only_admin';

    const ON = 'on';

    const OFF = 'off';

    /**
     * 检查给定的状态值是否符合当前状态
     *
     * @param $value string 给定的状态值
     *
     * @return bool 如果状态值与当前状态符合则返回true，比如说给定状态值是Switch_Status::ONLY_USER而当前正好处在用户前端就会返回true
     */
    static public function check_status( $value ) {
        if ( Switch_Status::OFF === $value ) {
            return false;
        } elseif ( Switch_Status::ONLY_USER === $value && is_admin() ) {
            return false;
        } elseif ( Switch_Status::ONLY_ADMIN === $value && ! is_admin() ) {
            return false;
        }

        return true;
    }

    static public function get_switch( $name, $value, $type = 'advanced' ) {
?>
<select class="regular" name="wp-china-yes[<?php echo $name; ?>]" id="wp-china-yes[<?php echo $name; ?>]">
    <?php if ( 'advanced' === $type ): ?>
    <option value="<?php echo self::ONLY_USER; ?>" <?php selected( $value, self::ONLY_USER ); ?>>前台开启</option>
    <option value="<?php echo self::ONLY_ADMIN; ?>" <?php selected( $value, self::ONLY_ADMIN ); ?>>后台开启</option>
    <?php endif; ?>
    <option value="<?php echo self::ON; ?>" <?php selected( $value, self::ON ); ?>><?php echo 'advanced' === $type ? '全局开启' : '启用' ?></option>
    <option value="<?php echo self::OFF; ?>" <?php selected( $value, self::OFF ); ?>>禁用</option>
</select>
<?php
    }

}
