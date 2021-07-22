<?php
namespace LitePress\WP_China_Yes\Template;

use function LitePress\WP_China_Yes\Inc\get_switch;

global $wp_china_yes;

if ( 'POST' === $_SERVER['REQUEST_METHOD'] ?? 'GET' ) {
    if ( wp_verify_nonce( $_POST['wcy-from-nonce'], 'wcy-from-nonce' ) ) {
        foreach ( $_POST['wp-china-yes'] as $key => $value ) {
            $wp_china_yes->{'set_' . $key}( sanitize_key( $value ) );
        }

        $wp_china_yes->save();
    }
}
?>
<div class="metabox-holder">
  <div id="wpcy_basics" class="group">
    <form method="post">
      <input type="hidden" name="wcy-from-nonce" value="<?php echo wp_create_nonce( 'wcy-from-nonce' ) ?>"/>
      <h2>WP-China-Yes</h2>
      <table class="form-table" role="presentation">
        <tbody>
        <tr>
          <th scope="row">
            <label>应用市场</label>
          </th>
          <td>
            <select class="regular" name="wp-china-yes[store_mode]" id="wp-china-yes[store_mode]">
              <option value="<?php echo $wp_china_yes::LP_STORE; ?>" <?php selected( $wp_china_yes::LP_STORE, $wp_china_yes->get_store_mode() ); ?>>
                LitePress应用市场
              </option>
              <option value="<?php echo $wp_china_yes::WP_STORE_MIRROR; ?>" <?php selected( $wp_china_yes::WP_STORE_MIRROR, $wp_china_yes->get_store_mode() ); ?>>
                WordPress应用市场镜像
              </option>
              <option value="<?php echo $wp_china_yes::WP_STORE; ?>" <?php selected( $wp_china_yes::WP_STORE, $wp_china_yes->get_store_mode() ); ?>>
                不接管应用市场
              </option>
            </select>
            <p class="description">选择你想使用的应用市场</p>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <label>加速管理后台</label>
          </th>
          <td>
              <?php get_switch( 'admin_assets_replace', $wp_china_yes->get_admin_assets_replace(), 'mini' ); ?>
            <p class="description">将WordPress核心所依赖的静态文件切换为公共资源，此选项极大的加快管理后台访问速度</p>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <label>Gravatar头像加速</label>
          </th>
          <td>
              <?php get_switch( 'gravatar_replace', $wp_china_yes->get_gravatar_replace() ); ?>
            <p class="description">为Gravatar头像加速，推荐所有用户启用该选项</p>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <label>加速谷歌字体</label>
          </th>
          <td>
              <?php get_switch( 'googlefonts_replace', $wp_china_yes->get_googlefonts_replace() ); ?>
            <p class="description">请只在包含谷歌字体的情况下才启用该选项，以免造成不必要的性能损失</p>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <label>加速谷歌前端公共库</label>
          </th>
          <td>
              <?php get_switch( 'googleajax_replace', $wp_china_yes->get_googleajax_replace() ); ?>
            <p class="description">请只在包含谷歌前端公共库的情况下才启用该选项，以免造成不必要的性能损失</p>
          </td>
        </tr>
        </tbody>
      </table>
      <div style="padding-left: 10px">
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="保存更改"></p>
      </div>
    </form>
  </div>
</div>
