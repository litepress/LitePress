<?php

namespace LitePress\WP_China_Yes\Inc\DataObject;

final class Options {

    const ONLY_USER = 'only-user';

    const ONLY_ADMIN = 'only-admin';

    const ON = 'on';

    const OFF = 'off';

    const WP_STORE = 'wp-store';

    const WP_STORE_MIRROR = 'wp-store-mirror';

    const LP_STORE = 'lp-store';

    private static $instance;

    /**
     * @var User_Info
     */
    private $user_info = null;

    /**
     * @var string
     */
    private $store_mode = self::LP_STORE;

    /**
     * @var string
     */
    private $googlefonts_replace = '';

    /**
     * @var string
     */
    private $googleajax_replace = '';

    /**
     * @var string
     */
    private $gravatar_replace = '';

    /**
     * @var string
     */
    private $admin_assets_replace = '';

    /**
     * 单例模式下禁用类构造
     */
    private function __construct() {
    }

    /**
     * 获取对象实例
     *
     * @return Options
     */
    public static function get_instance(): Options {
        if ( ! ( self::$instance instanceof self ) ) {
            // 获取对象实例时直接读取并填充设置值
            $args = get_option( 'wp-china-yes', array() );

            $defaults = array(
                'user_info'            => new User_Info(),
                'store_mode'           => self::LP_STORE,
                'gravatar_replace'     => self::ON,
                'admin_assets_replace' => self::OFF,
                'googleajax_replace'   => self::OFF,
                'googlefonts_replace'  => self::OFF,
            );
            $args     = wp_parse_args( $args, $defaults );

            $object                       = new self();
            $object->user_info            = $args['user_info'];
            $object->store_mode           = $args['store_mode'];
            $object->gravatar_replace     = $args['gravatar_replace'];
            $object->admin_assets_replace = $args['admin_assets_replace'];
            $object->googleajax_replace   = $args['googleajax_replace'];
            $object->googlefonts_replace  = $args['googlefonts_replace'];

            self::$instance = $object;
        }

        return self::$instance;
    }

    /**
     * 将对象中的设置值更新到数据中
     *
     * 该方法通常出现在对象属性设置的链式调用末尾
     */
    public function save() {
        $args = array(
            'user_info'            => $this->get_user_info(),
            'store_mode'           => $this->get_store_mode(),
            'gravatar_replace'     => $this->get_gravatar_replace(),
            'admin_assets_replace' => $this->get_admin_assets_replace(),
            'googleajax_replace'   => $this->get_googleajax_replace(),
            'googlefonts_replace'  => $this->get_googlefonts_replace(),
        );

        update_option( 'wp-china-yes', $args );
    }

    /**
     * @return User_Info
     */
    public function get_user_info() {
        return $this->user_info;
    }

    /**
     * @param User_Info $user_info
     *
     * @return Options
     */
    public function set_user_info( User_Info $user_info ): Options {
        $this->user_info = $user_info;

        return $this;
    }

    /**
     * @return string
     */
    public function get_store_mode(): string {
        return $this->store_mode;
    }

    /**
     * @param string $store_mode
     *
     * @return Options
     */
    public function set_store_mode( string $store_mode ): Options {
        $this->store_mode = $store_mode;

        return $this;
    }

    /**
     * @return string
     */
    public function get_gravatar_replace(): string {
        return $this->gravatar_replace;
    }

    /**
     * @param string $gravatar_replace
     *
     * @return Options
     */
    public function set_gravatar_replace( string $gravatar_replace ): Options {
        $this->gravatar_replace = $gravatar_replace;

        return $this;
    }

    /**
     * @return string
     */
    public function get_admin_assets_replace(): string {
        return $this->admin_assets_replace;
    }

    /**
     * @param string $admin_assets_replace
     *
     * @return Options
     */
    public function set_admin_assets_replace( string $admin_assets_replace ): Options {
        $this->admin_assets_replace = $admin_assets_replace;

        return $this;
    }

    /**
     * @return string
     */
    public function get_googleajax_replace(): string {
        return $this->googleajax_replace;
    }

    /**
     * @param string $googleajax_replace
     *
     * @return Options
     */
    public function set_googleajax_replace( string $googleajax_replace ): Options {
        $this->googleajax_replace = $googleajax_replace;

        return $this;
    }

    /**
     * @return string
     */
    public function get_googlefonts_replace(): string {
        return $this->googlefonts_replace;
    }

    /**
     * @param string $googlefonts_replace
     *
     * @return Options
     */
    public function set_googlefonts_replace( string $googlefonts_replace ): Options {
        $this->googlefonts_replace = $googlefonts_replace;

        return $this;
    }

    /**
     * 单例模式下禁用Clone
     */
    private function __clone() {
    }

}
