var $ = jQuery.noConflict();
const api_domain = location.origin + "/wp-json";


$(".f-sort a").each(function () {
    var url = Url.queryString("orderby");
    var rel = $(this).attr('rel');
    if (url === rel) {
        $(this).addClass("curr").siblings('a').removeClass('curr');
    } else if (url === undefined) {
        $(".f-sort a:first").addClass("curr");
    }
    $(this).on('click', function () {
        $(this).addClass("curr").siblings('a').removeClass('curr');
    })
});

$(function () {
    $('.current-page').keypress(function (e) {
        const key = e.charCode || e.keyCode || 0;
        if (key === 13) {//回车键
            const tPage = $(".tablenav.top .total-pages").text()//获取总页数
            let page = 1;
            if ($(this).val() > 0) {
                page = $(this).val();
            } else {
                page = 1;
            }
            /*    gotoPage(page);//跳转请求数据*/
            Url.updateSearchParam("paged", page);
            window.location.href = Url.getLocation();
            //return false;
        }
        //return this;
    });

    /*主题按钮功能*/
    $('.collapse-sidebar.button').click(function () {
        $('.wp-full-overlay').toggleClass('collapsed expanded');
    });

    $('.close-full-overlay').click(function () {
        parent.tb_remove();
    });

    /*协议流程*/
    $.ajax({
        url: "https://litepress.cn/store/wp-json/wp/v2/pages/246953",
        type: 'GET',
        dataType: 'json',
        success: function (data) { //请求成功完成后要执行的方法
            const title = data.title.rendered;
            const content = data.content.rendered;
            $(".plugin-action-buttons li dialog").find(".protocol_header h2").text(title).end().find(".protocol_article").html(content);
        },
        error: function (error) {
            console.log(error);
        },
    })


    /*同意流程*/
    $(".checkout .apply_coupon").click(function () {
        const coupon_code = $(this).parent().prev().find("input").val();
        const cart_subtotal = $(this).parent().parent().parent().parent().find(".cart-subtotal");
        const cart_subtotal_val = $(cart_subtotal).find("b").text();
        $.ajax({
            url: api_domain + "/lp-api/v1/coupons",
            type: "get",
            dataType: "JSON",
            data: {code: coupon_code},
            success: function (data) {
                console.log(data);
                if (parseInt(data[0].amount) >= parseInt(cart_subtotal_val)) {
                    amount = cart_subtotal_val;
                } else {
                    amount = data[0].amount;
                }

                $(cart_subtotal).after("<tr class=\"cart-discount coupon-" + coupon_code + "\">" +
                    "<th>优惠券：" + coupon_code + "</th>\n" +
                    "<td>-<span class=\"woocommerce-Price-amount amount\"><span class=\"woocommerce-Price-currencySymbol\">¥</span><b>" + amount + "</b></span><!-- <a href=\"https://litepress.cn/store/checkout?remove_coupon=bax62gpg\" class=\"woocommerce-remove-coupon\" data-coupon=\"bax62gpg\">[移除]</a>--></td>\n" +
                    "</tr>")
                count();
            },
            error: function (error) {
                console.log(error);
            },
            complete: function () {
            },


        })
    })


    /*优惠券下拉*/
    $(".showcoupon").click(function () {
        $(this).parent().parent().next().slideToggle();
        if ($('.checkout_coupon').is(":visible")) {
            top_val = $("#TB_window").css("margin-top")
            $("#TB_window").css("margin-top", "-17%")
        } else {
            top_val = $("#TB_window").css("margin-top")
            $("#TB_window").css("margin-top", top_val)
        }
    })

    /*购买按钮函数*/
    $(".buy_plugin_btn").click(function () {
        $("section.checkout").show().siblings().hide();
        count();
        $(".buy_agreement").click(function () {
            $("section.checkout").hide();
            $("section.protocol").show();
            $(this).parent().parent().find("#users_can_register").attr("checked", true);
        })
        $(".agree_btn").click(function () {
            $(this).parent().parent().hide().siblings().show();
        })
    });


    /*计算折扣金额*/
    function count() {
        $(" .order-total").each(function () {
            cart_subtotal = $(this).parent().find(".cart-subtotal b").text();
            cart_discount = $(this).parent().find(".cart-discount b").text();
            order_total = cart_subtotal - cart_discount
            $(this).find("b").text(order_total)
        })
    }

    /*支付流程*/
    $(".checkout .buy_btn").click(function () {
        if ($(this).prev().find('#users_can_register').is(':checked')) {
            $(this).parent().parent().parent().parent().hide();
            $("section.wp-pay").show().siblings().hide();
            const product_id = $(this).attr("product_id");
            const coupon_code = $(this).parent().parent().parent().parent().find("#coupon_code").val();
            $.ajax({
                url: api_domain + "/lp-api/v1/orders",
                type: "post",
                dataType: "JSON",
                data: {
                    product_id: product_id,
                    coupon_code: coupon_code,
                },
                success: function (data) {
                    console.log(data);
                    localStorage.setItem("local_order_id", data.id);
                    if (data.pay_url === undefined || data.pay_url.length === 0) {
                        $(".qrcode").html("支付成功")
                    } else {
                        $(".qrcode").html("").qrcode(data.pay_url);
                        $('.authentication-message').html("支付状态：查询中<i\n" + " class=\"loading\"></i>");
                        setInterval(function () {
                            Payment_query();
                        }, 1000)
                    }
                },
                error: function (error) {
                    console.log(error);
                    $('.authentication-message').html("发生未知错误，请重试");
                },
                complete: function () {
                },
            })
        } else {
            alert("您必须同意协议才能进行支付");
            $("section.wp-pay").hide();
        }
    })


    /*封装支付查询*/
    function Payment_query() {
        $.ajax({
            url: api_domain + "/lp-api/v1/orders/is_paid",
            type: "GET",
            dataType: "JSON",
            data: {
                order_id: localStorage.getItem("local_order_id"),
            },
            beforeSend: function (XMLHttpRequest) {
                /*XMLHttpRequest.setRequestHeader("X-WP-Nonce", wprpv_rest_api_nonce);*/
            },
            error: function (error) {
                /*            if( error.responseJSON.message.length !== 0 ) {
                                /!*$(".qrcode").html("");*!/
                                $('.authentication-message').html(error.responseJSON.message);
                            }*/
                console.log(error);
            },
            complete: function () {
            },
            success: function (data) {
                /*console.log(data);*/
                if (data.status === "unpaid") {
                    status = "未支付"
                } else if (data.status === "paid") {
                    status = "支付成功";
                    $(".qrcode").html("");
                }
                $('.authentication-message').html("支付状态：" + status);

            }
        });
    }

    $('.wp-pwd button').click(function()
    {
        $(this).find("span").toggleClass('dashicons-visibility dashicons-hidden');
       type = $(this).prev().attr("type");

       if (type==="password"){
           $(this).prev().prop('type', 'text')
    }
        else {
           $(this).prev().prop('type', 'password')
       }
    });

    /*登录流程*/
    $(".wp_login_btn").click(function () {
        user_login = $("#user_login").val();
        password = $("#user_pass").val();
        $.ajax({
            url: api_domain + "/lp-api/v1/login",
            type: "post",
            dataType: "JSON",
            data: {
                user_login: user_login,
                password: password,
            },
            beforeSend: function (data) {
                $("#wp-submit").before("<span class=\"spinner is-active\"></span>")
            },
            success: function (data) {
                $("#login_error").remove("");
                window.location.reload();
            },
            error: function (error) {
                login_val = $("#user_login").val();
                pass_val = $("#user_pass").val();
                if (login_val === "" && pass_val === "") {
                    $("#login_error,.spinner").remove("");
                    $(".navbar-brand").after("<div id=\"login_error\">\t<strong>错误</strong>：用户名字段为空。<br>\n" +
                        "\t<strong>错误</strong>：密码字段为空。<br>\n" +
                        "</div>")
                } else if (error.responseJSON.message==="账户或密码不正确") {
                    $("#login_error,.spinner").remove("");
                    $(".navbar-brand").after("<div id=\"login_error\">\t<strong>错误</strong>：您输入的密码不正确。 <a href=\"https://litepress.cn/wp-login.php?action=lostpassword\">忘记密码？</a><br>\n" +
                        "</div>")
                }
                console.log(error);
            },
            complete: function () {
            },
        })
    })

    /*注销流程*/
    $(".logout").click(function () {
        $.ajax({
            url: api_domain + "/lp-api/v1/logout",
            type: "post",
            dataType: "JSON",
            success: function (data) {
                window.location.reload();
            },
            error: function (error) {
                console.log(error);
            },
            complete: function () {
            },
        })
    })
    /*搜索*/
    $(".wp-filter-search").on("input", function () {
        const input_val = $(this).val();
        const href = location.href;
        const typeselector = $("#typeselector").val()
        $(this).keydown(function (event) {
            let content;
            if (event.keyCode === 13) {
                $(location).prop('href', href + "&search=" + input_val + "&search_by=" + typeselector);

            } else if (typeselector === "tag") {
                content = "";
                $.ajax({
                    url: "https://api.litepress.cn/lp/tags?search=" + input_val,
                    type: "GET",
                    dataType: "JSON",
                    beforeSend: function (data) {
                        $(" .ajax_loading").removeClass("hidden")
                    },
                    success: function (data) {
                        /*console.log(data.data);*/
                        $.each(data.data, function (wp, val) {
                            url = $(location).attr('href');
                            url_noparm = url.split("&").splice(0, 1).join("");
                            content += "<li>" + "<a " + "href='" + url_noparm + "&search=" + val.slug + "&search_by=tag" + "'><span>" + val.name + "</span><aside>" + val.count + "条结果</aside>" + "</a>" + "</li>";
                            $("#showDiv").slideDown().html(content);
                        });
                        $(" .ajax_loading").addClass("hidden");

                        $(document).click(function (e) {
                            const $target = $(e.target);
                            if (!$target.is('#showDiv *')) {
                                $('#showDiv').slideUp();
                            }
                        });
                    },
                    error: function () {

                    }
                });
            } else if (typeselector === "author") {
                content = "";
                $.ajax({
                    url: "https://api.litepress.cn/lp/vendors?search=" + input_val,
                    type: "GET",
                    dataType: "JSON",
                    beforeSend: function (data) {
                        $(" .ajax_loading").removeClass("hidden")
                    },
                    success: function (data) {
                        /*console.log(data.data);*/
                        $.each(data.data, function (wp, val) {
                            url = $(location).attr('href');
                            url_noparm = url.split("&").splice(0, 1).join("");
                            content += "<li>" + "<a " + "href='" + url_noparm + "&search=" + val.slug + "&search_by=author" + "'><span>" + val.name + "</span><aside>" + val.count + "条结果</aside>" + "</a>" + "</li>";
                            $("#showDiv").slideDown().html(content);
                        });
                        $(" .ajax_loading").addClass("hidden");

                        $(document).click(function (e) {
                            const $target = $(e.target);
                            if (!$target.is('#showDiv *')) {
                                $('#showDiv').slideUp();
                            }
                        });
                    },
                    error: function () {

                    }
                });
            }


        })

    });

    window.onload = function () {
        search_val = Url.queryString("search");
        search_by = Url.queryString("search_by");
        if (search_val !== undefined) {
            $(".wp-filter-search").val(search_val)
            $("#typeselector").val(search_by)
        }
    }


    function search() {


    }


});