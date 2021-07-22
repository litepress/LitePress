<?php

namespace LitePress\WP_China_Yes\Template;

use stdClass;
use function LitePress\WP_China_Yes\Inc\get_how_ago;
use function LitePress\WP_China_Yes\Inc\get_template_part;
use function LitePress\WP_China_Yes\Inc\pagination;
use function LitePress\WP_China_Yes\Inc\prepare_installed_num;
use function LitePress\WP_China_Yes\Inc\prepare_price_for_html;

$tpl_args = $tpl_args ?? array(
        'projects'           => array(),
        'all_local_projects' => array(),
        'cats'               => new stdClass(),
        'total'              => 0,
        'totalpages'         => 0,
        'paged'              => 0,
    );

?>

<?php add_action( 'wcy_search_form', function () { ?>
  <form class="search-form search-plugins header-search" method="get">
    <input type="hidden" name="tab" value="search"/>
    <label class="screen-reader-text" for="typeselector">搜索插件：</label>
    <select name="type" id="typeselector">
      <option value="term" selected='selected'>关键词</option>
      <option value="author">作者</option>
      <option value="tag">标签</option>
    </select>
    <label class="screen-reader-text" for="search-plugins">搜索插件</label>
    <input type="search" name="s" AUTOCOMPLETE="off" id="search-plugins" value="" class="wp-filter-search"
           placeholder="搜索插件…"/>
    <button type="submit">
      <div><i class="fas fa-search"></i>
        <div class="ajax_loading hidden">
          <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas"
               data-icon="spinner" class="svg-inline--fa fa-spinner fa-w-16" role="img" viewBox="0 0 512 512">
            <path fill="currentColor"
                  d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z"/>
          </svg>
        </div>
        <div class="clear hidden">
          <i class="fa fa-close"></i>
        </div>
      </div>
    </button>
    <ul id="showDiv" tabindex="0"
        class="ui-menu ui-widget ui-widget-content  ui-front lava_ajax_search hidden"></ul>
    <input type="submit" id="search-submit" class="button hide-if-js" value="搜索插件"/>
  </form>
<?php } ); ?>

<?php get_template_part( 'header' ); ?>

<section class="wcy-filter wp-filter">
  <div class="row theme-boxshadow">
    <ul>
      <li>
        <i>价格：</i>
        <span class="filter-cost">
            <ul class="filter-cost-ul">
              <li class="all">
                <a href="<?php echo remove_query_arg( array(
                    'min_price',
                    'max_price'
                ) ) ?>" <?php echo ! isset( $_GET['max_price'] ) && ! isset( $_GET['min_price'] ) ? 'class="active"' : '' ?>>全部</a>
              </li>
              <li>
                <a href="<?php echo add_query_arg( array(
                    'min_price' => '0',
                    'max_price' => '0.01',
                ) ) ?>" <?php echo isset( $_GET['max_price'] ) && '0.01' === $_GET['max_price'] ? 'class="active"' : '' ?>>免费</a>
              </li>
              <li>
                <a href="<?php echo add_query_arg( array(
                    'min_price' => '0.01',
                    'max_price' => '100000',
                ) ) ?>" <?php echo isset( $_GET['min_price'] ) && '0.01' === $_GET['min_price'] ? 'class="active"' : '' ?>>付费</a>
              </li>
            </ul>
          </span>
      </li>
      <li>
        <i>分类：</i>
        <span class="filter-categories">
              <ul class="filter-cost-ul">
                <li class="all">
                  <a href="<?php echo remove_query_arg( array( 'sub_cat' ) ) ?>"
                     class="categories-a <?php echo ! isset( $_GET['sub_cat'] ) ? 'active' : '' ?>">全部</a></li>
                <?php foreach ( (array) $tpl_args['cats']->plugins as $sub_cat ): ?>
                    <?php
                    printf( '<li><a href="%s" class="categories-a %s">%s</a></li>',
                        add_query_arg( array( 'sub_cat' => $sub_cat->term_id ) ),
                        isset( $_GET['sub_cat'] ) && (string) $sub_cat->term_id === $_GET['sub_cat'] ? 'active' : '',
                        $sub_cat->terms->name
                    );
                    ?>
                <?php endforeach; ?>
              </ul>
          </span>
      </li>
    </ul>
  </div>
</section>

<form id="plugin-filter" method="post">
  <section class="woo-ordering">
    <div class="f-sort">
      <a href="<?php echo add_query_arg( array( 'orderby' => 'popularity' ) ); ?>"
         class="sort_popularity <?php echo ! isset( $_GET['orderby'] ) || 'popularity' === $_GET['orderby'] ? 'curr' : '' ?>"
         title="按销量排序" rel="popularity">
        <span class="fs-tit">销量</span>
        <em class="fs-down">
          <span class="dashicons dashicons-arrow-down-alt"></span>
        </em>
      </a>
      <a href="<?php echo add_query_arg( array( 'orderby' => 'rating' ) ); ?>"
         class="sort_rating <?php echo isset( $_GET['orderby'] ) && 'rating' === $_GET['orderby'] ? 'curr' : '' ?>"
         title="按好评度排序" rel="rating">
        <span class="fs-tit">好评度</span>
        <em class="fs-down">
          <span class="dashicons dashicons-arrow-down-alt"></span>
        </em>
      </a>
      <a href="<?php echo add_query_arg( array( 'orderby' => 'date' ) ); ?>"
         class="sort_date <?php echo isset( $_GET['orderby'] ) && 'date' === $_GET['orderby'] ? 'curr' : '' ?>"
         title="按最新内容排序" rel="date">
        <span class="fs-tit">新品</span>
        <em class="fs-down">
          <span class="dashicons dashicons-arrow-down-alt"></span>
        </em>
      </a>
      <a href="<?php echo add_query_arg( array( 'orderby' => 'price', 'order' => 'asc' ) ); ?>"
         class="sort_price <?php echo isset( $_GET['orderby'] ) && 'price' === $_GET['orderby'] && isset( $_GET['order'] ) && 'asc' === $_GET['order'] ? 'curr' : '' ?>"
         title="按价格从低到高排序" rel="price">
        <span class="fs-tit">价格</span>
        <em class="fs-up">
          <span class="dashicons dashicons-arrow-up-alt"></span>
        </em>
      </a>
      <a href="<?php echo add_query_arg( array( 'orderby' => 'price', 'order' => 'desc' ) ); ?>"
         class="sort_price-desc <?php echo isset( $_GET['orderby'] ) && 'price' === $_GET['orderby'] && ( ! isset( $_GET['order'] ) || 'desc' === $_GET['order'] ) ? 'curr' : '' ?>"
         title="按价格从高到低排序" rel="price-desc">
        <span class="fs-tit">价格</span>
        <em class="fs-down">
          <span class="dashicons dashicons-arrow-down-alt"></span>
        </em>
      </a>
    </div>
    <div class="tablenav top">
      <div class="alignleft actions"></div>
      <h2 class="screen-reader-text">插件列表导航</h2>
        <?php pagination( $tpl_args['total'], $tpl_args['totalpages'], $tpl_args['paged'] ); ?>
    </div>
  </section>
</form>

<div class="wp-list-table widefat plugin-install">
  <h2 class='screen-reader-text'>插件列表</h2>
  <div id="the-list">
      <?php foreach ( $tpl_args['projects'] as $project ): ?>
        <div details_url
             class="plugin-card plugin-card-<?php echo $project->slug; ?> type-<?php echo $project->type ?>">
          <div class="plugin-card-top">
            <div class="name column-name">
                <?php
                $args               = array(
                    'tab'       => 'plugin-information',
                    'plugin'    => $project->slug,
                    'TB_iframe' => true,
                    'width'     => 800,
                    'height'    => 700,
                );
                $plugin_details_url = add_query_arg( $args, admin_url( 'plugin-install.php' ) );
                ?>
              <h3>
                <a href="<?php echo $plugin_details_url; ?>"
                   class="thickbox open-plugin-details-modal">
                    <?php echo $project->name; ?>
                  <img src="<?php echo $project->thumbnail_src; ?>" class="plugin-icon" alt=""/>
                  <section class="img-box"></section>
                </a>
              </h3>
            </div>
            <div class="action-links">
              <ul class="plugin-action-buttons">
                <li>
                    <?php if ( (float) $project->price > 0 ): ?>
                      <a class="button thickbox buy_plugin_btn"
                         href="#TB_inline?height=220&width=600&inlineId=dialog-<?php echo $project->id ?>">购买</a>
                        <?php get_template_part( 'buy', '', array( 'project' => $project ) ); ?>
                    <?php elseif ( key_exists( $project->slug, $tpl_args['all_local_projects'] ) ): ?>
                        <?php if ( version_compare( $project->meta->_api_new_version, $tpl_args['all_local_projects'][ $project->slug ]['Version'] ?? '1000', '>' ) ): ?>
                            <?php
                            $args              = array(
                                '_wpnonce' => wp_create_nonce( 'upgrade-plugin_' . $project->slug ),
                                'action'   => 'upgrade-plugin',
                                'plugin'   => $tpl_args['all_local_projects'][ $project->slug ]['Plugin'] ?? '',
                            );
                            $plugin_update_url = add_query_arg( $args, admin_url( 'update.php' ) );
                            ?>
                        <a class="update-now button aria-button-if-js"
                           data-plugin="<?php echo $tpl_args['all_local_projects'][ $project->slug ]['Plugin'] ?>"
                           data-slug="<?php echo $project->slug ?>"
                           href="<?php echo $plugin_update_url ?>"
                           aria-label="更新<?php echo $project->name; ?> <?php echo $project->meta->_api_new_version ?>"
                           data-name="<?php echo $project->name; ?> <?php echo $project->meta->_api_new_version ?>"
                           role="button">立即更新</a>
                        <?php elseif ( 'Activated' === $tpl_args['all_local_projects'][ $project->slug ]['Status'] ?? '' ): ?>
                        <button type="button" class="button button-disabled"
                                disabled="disabled">已启用
                        </button>
                        <?php else: ?>
                            <?php
                            $args              = array(
                                '_wpnonce' => wp_create_nonce( 'active_' . $project->slug ),
                                'action'   => 'active',
                                'plugin'   => $tpl_args['all_local_projects'][ $project->slug ]['Plugin'] ?? '',
                            );
                            $plugin_active_url = add_query_arg( $args, admin_url( 'plugins.php' ) );
                            ?>
                        <a class="button activate-now" data-slug="<?php echo $project->slug; ?>"
                           href="<?php echo $plugin_active_url; ?>" aria-label="启用现在安装<?php echo $project->name; ?>"
                           data-name="<?php echo $project->name; ?> <?php echo $project->meta->_api_new_version ?>">启用</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php
                        $args               = array(
                            '_wpnonce' => wp_create_nonce( 'install-plugin_' . $project->slug ),
                            'action'   => 'install-plugin',
                            'plugin'   => $project->slug,
                        );
                        $plugin_install_url = add_query_arg( $args, admin_url( 'update.php' ) );
                        ?>
                      <a class="install-now button" data-slug="<?php echo $project->slug; ?>"
                         href="<?php echo $plugin_install_url; ?>"
                         aria-label="现在安装<?php echo $project->name; ?> <?php echo $project->meta->_api_new_version ?>"
                         data-name="<?php echo $project->name; ?> <?php echo $project->meta->_api_new_version ?>">现在安装</a>
                    <?php endif; ?>
                </li>
                <li>
                  <td class="product-total">
                      <?php prepare_price_for_html( (int) $project->price ); ?>
                  </td>
                </li>
                <li>
                  <a href="<?php echo $plugin_details_url; ?>"
                     class="thickbox open-plugin-details-modal"
                     aria-label="关于<?php echo $project->name; ?>的更多信息"
                     data-title="<?php echo $project->name; ?>">更多详情
                  </a>
                </li>

              </ul>
            </div>
            <div class="desc column-description">
              <p><?php echo $project->short_description; ?></p>
              <p class="authors">
                <cite>
                    <?php if ( ! empty( $project->vendor ) ): ?>
                      作者：
                        <?php
                        /**
                         * TODO:点击作者名字应该筛选该作者的作品
                         */
                        ?>
                      <a href="https://litepress.cn/store/archives/product-vendors/"><?php echo $project->vendor->name ?></a>
                    <?php else: ?>
                      作者：未知
                    <?php endif; ?>
                </cite>
              </p>
            </div>
          </div>
          <div class="plugin-card-bottom">
            <div class="vers column-rating">
              <div class="star-rating">
                <span class="screen-reader-text"><?php echo $project->average_rating ?>星（基于<?php echo $project->rating_count ?>个评级）</span>
                  <?php $rating_num_tmp = (float) $project->average_rating; ?>
                  <?php for ( $i = 0; $i < 5; $i ++ ): ?>
                      <?php if ( 0 < $rating_num_tmp && $rating_num_tmp < 1 ): ?>
                      <span class="star dashicons dashicons-star-half"></span>
                      <?php elseif ( $rating_num_tmp >= 1 ): ?>
                      <span class="star dashicons dashicons-star-filled"></span>
                      <?php else: ?>
                      <span class="star dashicons dashicons-star-empty"></span>
                      <?php endif; ?>
                  <?php endfor; ?>
              </div>
              <span class="num-ratings"
                    aria-hidden="true">(<?php echo $project->rating_count ?>)</span>
            </div>
            <div class="column-updated">
              <strong>最近更新：</strong>
                <?php echo get_how_ago( strtotime( $project->date_modified ) ) ?>
            </div>
            <div class="column-downloaded">
                <?php echo prepare_installed_num( $project->total_sales ) ?>安装
            </div>
            <div class="column-compatibility">
                <?php if ( empty( $project->meta->_api_version_required ) ): ?>
                  插件兼容性未知
                <?php elseif ( version_compare( $GLOBALS['wp_version'], $project->meta->_api_version_required, '>' ) ): ?>
                  <span class="compatibility-compatible">该插件<strong>兼容</strong>于您当前使用的WordPress版本</span>
                <?php else: ?>
                  <span class="compatibility-compatible">该插件<strong>不兼容</strong>于您当前使用的WordPress版本</span>
                <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
  </div>
</div>
<div class="tablenav bottom">
    <?php pagination( $tpl_args['total'], $tpl_args['totalpages'], $tpl_args['paged'] ); ?>
  <br class="clear">
</div>

<?php get_template_part( 'footer' ); ?>

