<?php

namespace LitePress\WP_China_Yes\Template;

use function LitePress\WP_China_Yes\Inc\get_template_part;

$tpl_args = $tpl_args ?? array(
        'apps' => array(),
    );

?>

<?php add_action( 'wcy_search_form', function () { ?>
  <form class="search-form search-plugins" method="get">
    <input type="hidden" name="tab" value="search"/>
    <label class="screen-reader-text" for="typeselector">搜索已购列表：</label>
    <select name="type" id="typeselector">
      <option value="term" selected='selected'>关键词</option>
      <option value="author">作者</option>
      <option value="tag">标签</option>
    </select>
    <label class="screen-reader-text" for="search-plugins">搜索已购列表</label>
    <input type="search" name="s" id="search-plugins" value="" class="wp-filter-search" placeholder="搜索已购列表…"/>
    <input type="submit" id="search-submit" class="button hide-if-js" value="搜索已购列表"/>
  </form>
<?php } ); ?>

<?php get_template_part( 'header' ); ?>

<form id="plugin-filter" method="post">

  <div class="wp-list-table widefat plugin-install">
    <h2 class='screen-reader-text'>插件列表</h2>
    <table class="wp-list-table widefat plugins">
      <thead>
      <tr>
        <td class="account_list_thead_first">图标</td>
        <th scope="col" id="name" class="manage-column column-name column-primary">标题</th>
        <th scope="col" id="description" class="manage-column column-description">描述</th>
      </tr>
      </thead>

      <tbody id="the-list">
      <?php foreach ( (array) $tpl_args['apps'] as $app ): ?>
        <tr class="account_list_tbody_first" data-slug="bbpress" data-plugin="bbpress/bbpress.php">
          <th scope="row" class="check-column">
            <div>
              <img src="<?php echo $app->thumbnail_src ?: 'https://avatar.ibadboy.net/avatar/' . md5( rand() ) . '?d=identicon&s=256' ?>"
                   class="" alt="" width="56" height="56"></div>
          </th>
          <td class="plugin-title column-primary account_list_tbody_second">
            <strong><?php echo $app->name ?></strong>
            <div class="row-actions visible">
              <span class="activate">
                <a href="plugins.php?action=activate&amp;plugin=bbpress%2Fbbpress.php&amp;plugin_status=all&amp;paged=1&amp;s&amp;_wpnonce=97b5c01251"
                   id="activate-bbpress" class="edit" aria-label="在站点网络中启用bbPress">安装</a> |
              </span>
              <span class="0">
                  <a class="thickbox" title="授权码"
                     href="#TB_inline?height=800&width=1000&inlineId=donate-<?php echo $app->id; ?>">授权码(<?php echo count( $app->order_api_keys ) ?>个)
                  </a>
                  <div id="donate-<?php echo $app->id; ?>" style="display:none;">
                      <table class="wp-list-table thickbox_table widefat fixed striped table-view-list posts">
                    <thead>
                    <tr>
                        <th scope="col" class="manage-column">
                            <span class="tips">KEY</span>
                        </th>
                        <th scope="col" class="manage-column">
                            <span class="tips">已激活数</span>
                        </th>
                        <th scope="col" class="manage-column">
                            <span class="tips">可激活总数</span>
                        </th>
                    </thead>

                    <tbody id="the-list">
                      <?php foreach ( (array) $app->order_api_keys as $order_api_key ): ?>
                        <tr>
                            <td><?php echo $order_api_key->product_order_api_key ?: ''; ?></td>
                            <td><?php echo $order_api_key->activations_total ?: 0; ?></td>
                            <td><?php echo $order_api_key->activations_purchased_total ?: 0; ?></td>
                        </tr>
                      <?php endforeach; ?>
                        </tbody>
                    </table>
                  </div>
                </span>
            </div>
            <button type="button" class="toggle-row"><span class="screen-reader-text">显示详情</span>
            </button>
          </td>
          <td class="column-description desc">
            <div class="plugin-description"><p><?php echo $app->short_description ?></p></div>
            <div class="inactive second plugin-version-author-uri"><?php echo $app->version ?>版本 | 作者：
              <a href="https://<?php echo $app->author->slug ?? '' ?>"><?php echo $app->author->name ?? '' ?></a>
              | <a
                      href="https://litepress.cn/wp-admin/network/plugin-install.php?tab=plugin-information&amp;plugin=bbpress&amp;TB_iframe=true&amp;width=600&amp;height=550"
                      class="thickbox open-plugin-details-modal" aria-label="关于bbPress的更多信息"
                      data-title="bbPress">查看详情</a>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
      <tfoot>
      <tr>
        <td class="account_list_thead_first">图标</td>
        <th scope="col" id="name" class="manage-column column-name column-primary">标题</th>
        <th scope="col" id="description" class="manage-column column-description">描述</th>
      </tr>
      </tfoot>
    </table>
  </div>
  <div class="tablenav bottom">
    <br class="clear">
  </div>
</form>

<?php get_template_part( 'footer' ); ?>
