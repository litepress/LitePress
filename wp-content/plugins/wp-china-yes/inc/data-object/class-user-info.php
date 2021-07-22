<?php

namespace LitePress\WP_China_Yes\Inc\DataObject;

final class User_Info {

    /**
     * @var string
     */
    private $user_nicename = '';

    /**
     * @var string
     */
    private $user_display_name = '';

    /**
     * @var string
     */
    private $user_email = '';

    /**
     * @var string
     */
    private $token = '';

    /**
     * @return string
     */
    public function get_token(): string {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return User_Info
     */
    public function set_token( string $token ): User_Info {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string
     */
    public function get_user_display_name(): string {
        return $this->user_display_name;
    }

    /**
     * @param string $user_display_name
     *
     * @return User_Info
     */
    public function set_user_display_name( string $user_display_name ): User_Info {
        $this->user_display_name = $user_display_name;

        return $this;
    }

    /**
     * @return string
     */
    public function get_user_email(): string {
        return $this->user_email;
    }

    /**
     * @param string $user_email
     *
     * @return User_Info
     */
    public function set_user_email( string $user_email ): User_Info {
        $this->user_email = $user_email;

        return $this;
    }

    /**
     * @return string
     */
    public function get_user_nicename(): string {
        return $this->user_nicename;
    }

    /**
     * @param string $user_nicename
     *
     * @return User_Info
     */
    public function set_user_nicename( string $user_nicename ): User_Info {
        $this->user_nicename = $user_nicename;

        return $this;
    }

}
