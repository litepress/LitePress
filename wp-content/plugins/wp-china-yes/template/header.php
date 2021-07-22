<?php

namespace LitePress\WP_China_Yes\Template;

?>
<div class="wrap plugin-install-tab-featured">
  <section class="d-flex align-items-center">
    <div>
      <h1 class="wp-heading-inline">添加插件</h1>

      <a href="https://wptest.ibadboy.net/wp-admin/plugin-install.php?tab=upload"
         class="upload-view-toggle page-title-action">
        <span class="upload">上传插件</span>
        <span class="browse">浏览插件</span>
      </a></div>
    <div class="m-left-auto d-flex align-items-center login-content">
        <?php
        global $wp_china_yes;

        $user_info = $wp_china_yes->get_user_info();
        ?>
        <?php if ( ! empty( $user_info->get_token() ) ): ?>
          你已登录 LitePress.cn 账号:
          <a class="login-item" target="_blank"
             href="https://litepress.cn/user/<?php echo $user_info->get_user_nicename() ?>">
            <span class="display-name"><?php echo $user_info->get_user_display_name() ?></span>
          </a>

          <a class="button logout">注销</a>
        <?php else: ?>
          <a class="thickbox button button-primary" title="登录" href="#TB_inline?height=300&width=300&inlineId=login-1">
            登录 LitePress.cn 账号
          </a>

        <?php endif; ?>
      <div id="login-1" style="display:none;">
        <div class="login">
            <a class="navbar-brand" href="https://litepress.cn" target="_blank" one-link-mark="yes">
                <img src="https://litepress.cn/wp-content/uploads/2021/05/logo.svg" alt="LitePress 社区"
                     width="200"></a>
          <p>
            <label for="user_login">用户名或电子邮箱地址</label>
            <input type="text" name="log" id="user_login" class="input" value="" size="20" autocapitalize="none">
          </p>

          <div class="user-pass-wrap">
            <label for="user_pass">密码</label>
            <div class="wp-pwd">
              <input type="password" name="pwd" id="user_pass" class="input password-input" value="" size="20">
              <button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0"
                      aria-label="显示密码">
                <span class="dashicons dashicons-visibility" aria-hidden="true"></span>
              </button>
            </div>
          </div>
          <section class="submit">
              <p id="nav">
                  <a rel="nofollow" href="https://litepress.cn/wp-login.php?action=register" target="_blank"
                     one-link-mark="yes">注册</a> | <a href="https://litepress.cn/wp-login.php?action=lostpassword"
                                                     target="_blank" one-link-mark="yes">忘记密码？</a>
              </p>
            <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large wp_login_btn"
                   value="登录">
          </section>

        </div>
      </div>
  </section>
  <hr class="wp-header-end">
  <div class="upload-plugin-wrap">
    <div class="upload-plugin">
      <p class="install-help">如果您有.zip格式的插件文件，可以在这里通过上传安装它。</p>
      <form method="post" enctype="multipart/form-data" class="wp-upload-form"
            action="https://wptest.ibadboy.net/wp-admin/update.php?action=upload-plugin">
        <input type="hidden" id="_wpnonce" name="_wpnonce" value="8512c35e98"/>
        <input type="hidden" name="_wp_http_referer" value="/wp-admin/plugin-install.php"/>
        <label class="screen-reader-text" for="pluginzip">插件zip文件</label>
        <input type="file" id="pluginzip" name="pluginzip" accept=".zip"/>
        <input type="submit" name="install-plugin-submit" id="install-plugin-submit" class="button"
               value="现在安装"/>
      </form>
    </div>
  </div>
  <h2 class='screen-reader-text'>筛选插件列表</h2>
  <div class="wp-filter">
    <ul class="filter-links">
      <li class='plugin-install-featured'>
        <a href='<?php echo admin_url( 'admin.php?page=lpstore' ); ?>' <?php echo ( ! isset( $_GET['subpage'] ) || 'plugins' === $_GET['subpage'] ) ? 'class="current"' : '' ?>
           aria-current="page">插件</a>
      </li>
      <li class='plugin-install-popular'>
        <a href='<?php echo admin_url( 'admin.php?page=lpstore&subpage=themes' ); ?>' <?php echo ( 'themes' === ( $_GET['subpage'] ?? '' ) ) ? 'class="current"' : '' ?>>主题</a>
      </li>
      <li class='plugin-install-recommended'>
        <a href='<?php echo admin_url( 'admin.php?page=lpstore&subpage=account' ); ?>' <?php echo ( 'account' === ( $_GET['subpage'] ?? '' ) ) ? 'class="current"' : '' ?>>已购</a>
      </li>
      <li class='plugin-install-favorites'>
        <a target="_blank" href='https://litepress.cn/store/vendor-registration'>入驻</a>
      </li>
    </ul>

      <?php do_action( 'wcy_search_form' ); ?>
  </div>

