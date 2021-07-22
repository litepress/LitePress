<?php

namespace LitePress\WP_China_Yes\Template;

use stdClass;
use function LitePress\WP_China_Yes\Inc\prepare_price_for_html;

$tpl_args = $tpl_args ?? array(
        'project' => new stdClass(),
    );
$project = $tpl_args['project'];

?>
<dialog id="dialog-<?php echo $project->id ?>">
    <section class="checkout">
        <header><h2>结算</h2></header>
        <article>
            <div class="woocommerce-form-coupon-toggle">

                <div class="woocommerce-info">
                    有优惠券？ <a href="#"
                             class="showcoupon">点这里输入您的代码</a></div>
            </div>
            <section
                    class="checkout_coupon woocommerce-form-coupon bg-white theme-boxshadow"
                    method="post"
                    style="position: static; zoom: 1;display: none">

                <p>如果您有优惠券代码，请在下面应用代码。</p>
                <article>
                    <p class="form-row form-row-first">
                        <input type="text" name="coupon_code"
                               class="input-text"
                               placeholder="优惠券代码"
                               id="coupon_code" value="">
                    </p>

                    <p class="form-row form-row-last">
                        <button type="submit"
                                class="button apply_coupon"
                                name="apply_coupon"
                                value="使用优惠券">使用优惠券
                        </button>
                    </p>
                </article>
            </section>
            <table class="shop_table woocommerce-checkout-review-order-table">
                <thead>
                <tr>
                    <th class="product-name">产品</th>
                    <th class="product-total">小计</th>
                </tr>
                </thead>
                <tbody>
                <tr class="cart_item">
                    <td class="product-name">
                        <?php echo $project->name; ?><strong
                                class="product-quantity">×&nbsp;1</strong>
                        <dl class="variation">
                            <dt class="variation-">供应商:</dt>
                            <dd class="variation-"><p>
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
                                </p>
                            </dd>
                        </dl>
                    </td>
                    <td class="product-total">
                        <?php prepare_price_for_html( (int) $project->price ); ?>
                    </td>
                </tr>
                </tbody>
                <tfoot>

                <tr class="cart-subtotal">
                    <th>小计</th>
                    <td>
                                <span class="woocommerce-Price-amount amount">
                                  <bdi>
                                    <span class="woocommerce-Price-currencySymbol">¥</span>
                                    <b class="subtotal_price"><?php echo $project->price ?></b>
                                  </bdi>
                                </span>
                    </td>
                </tr>

                <tr class="order-total">
                    <th>合计</th>
                    <td>
                        <strong>
                                          <span class="woocommerce-Price-amount amount order-total-price"><bdi>
                                              <span class="woocommerce-Price-currencySymbol">¥</span>
                                              <b></b>
                                            </bdi>
                                          </span>
                        </strong>
                    </td>
                </tr>

                </tfoot>
            </table>
        </article>
        <footer>
            <div id="payment" class="woocommerce-checkout-payment">
                <ul class="wc_payment_methods payment_methods methods">
                    <li class="wc_payment_method payment_method_xh-wechat-payment-wc">
                        <input id="payment_method_xh-wechat-payment-wc"
                               type="radio"
                               class="input-radio"
                               name="payment_method"
                               value="xh-wechat-payment-wc"
                               checked="checked"
                               data-order_button_text=""
                               style="display: none;">

                        <label for="payment_method_xh-wechat-payment-wc">
                            微信支付 <img
                                    src="https://litepress.cn/store/wp-content/plugins/xunhupay-wechat-for-wc/images/logo/wechat.png"
                                    alt="微信支付"> </label>
                        <div class="payment_box payment_method_xh-wechat-payment-wc">
                            <p>二维码扫描支付或H5本地支付，信用卡支付</p>
                        </div>
                    </li>
                </ul>
                <div class="form-row place-order">
                    <noscript>
                        由于您的浏览器不支持JavaScript，或者它被禁用，在您付款之前请确保您单击的
                        <em>更新总计</em>按钮，如果您不这样做，您可能会支付更多钱。
                        <br/>
                        <button type="submit" class="button alt"
                                name="woocommerce_checkout_update_totals"
                                value="更新总数">更新总数
                        </button>
                    </noscript>

                    <div class="woocommerce-terms-and-conditions-wrapper">

                    </div>

                    <label for="users_can_register">
                        <input name="users_can_register"
                               type="checkbox"
                               id="users_can_register"
                               value="1" >
                        <a class="thickbox buy_agreement" href="#TB_inline?height=220&width=600&inlineId=dialog-1-<?php echo $project->id ?>">购买协议</a></label>
                    <a
                            class="button button-primary buy_btn thickbox" name="woocommerce_checkout_place_order"
                            id="place_order"
                            href="#TB_inline?height=220&width=600&inlineId=dialog-2-<?php echo $project->id ?>"
                            product_id="<?php echo $project->id ?>"
                    >支付
                    </a>
                </div>
            </div>
        </footer>
        <dialog id="dialog-1-<?php echo $project->id ?>">
            <section class="protocol">
                <header class="protocol_header"><h2></h2></header>
                <article class="protocol_article">
                </article>
                <footer>
                    <!--<a class="button button-primary agree_btn thickbox"
         href="#TB_inline?height=220&width=600&inlineId=dialog-1-<?php /*echo $project->id */?>">同意</a>
      <a class="button" onclick="tb_remove();">拒绝</a>-->
                    <a class="button agree_btn button-primary">我已阅读并同意协议</a>
                </footer>
            </section>
        </dialog>
        <dialog id="dialog-2-<?php echo $project->id ?>">
            <section class="wp-pay">
                <header><h2>支付</h2></header>
                <article>
                    <p>请扫描二维码前往微信支付</p>
                    <p class="authentication-message fade show alert-warning">获取中<i
                                class="loading"></i></p>
                    <div class="qrcode"></div>
                </article>
            </section>
        </dialog>
    </section>
</dialog>

