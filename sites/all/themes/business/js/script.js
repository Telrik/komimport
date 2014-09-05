(function ($) {
    function SetTip(select, pos) {
        select.data('tip_text', select.attr('title'));

        select.simpletip({
            content: select.attr('title'),
            fixed: true,
            position: pos
        });
        select.removeAttr('title');
    }

    $(function () {
        SetTip($("#edit-search-block-form--2"), [11, 39]);
        SetTip($(".asc"), [240, 16]);
        inputDefaultValue();

        setFilterFunctionalyty();

        setCallFancybox();
        setCallbackFancybox();
        setReviewFuncybox();
        setLogonFuncybox();
        setSitemapFuncybox();
        setPriceFuncybox();
        setDocFuncybox();

        if ($('#k_map').length) {
            ymaps.ready(function () {
                init('k_map')
            });

        }
        $(".search_prim").click(function () {
            $("#block-search-form .form-text").val($(this).text());
            return false;
        });
        setBrandsCarusel();
        //setCardActions();
        setCardDeleteActions();
        setXitsCarusel();
        setSpecCarusel();
        setKPFancy();
        setActionLink();
        setUserLink();
        setBuyButton();
        setProductSlider();


        $('.all_char, .delevary, .rev_count, .mods').click(function (event) {
            var tab = $(this).attr('href');
            $('#tabs').tabs('select', tab);
        });

        $("a.cloze_fancy").live("click", function () {
            $.fancybox.close();
            return false;
        });

        $(window).resize(function () {
            waitForFinalEvent(resizeEvent, 100, "some unique string");
        });


        var wiget_frames = $("#views-exposed-form-arts-page .views-exposed-widget");
        for (var i = 0; i < wiget_frames.length; ++i) {
            var wf = $(wiget_frames[i]), ln = $('<a class="drop_filter">Сбросить</a>');

            ln.click(function () {
                $(this).parents('.views-exposed-widget').find('select').multiselect("uncheckAll");
                return false;
            });
            wf.prepend(ln);
        }


        setInterval(function () {
            var nf = $('.not-front');

            ForeColumnHeight(nf.find('.product_frame .discript'));
            ForeColumnHeight(nf.find('.product_frame a.link'));
            ForeColumnHeight(nf.find('.product_frame .image_frame'));


            var fv = $("#brands_filter").val();
            if (fv != null) {
                $(".reset_filter").show();
            } else {
                $(".reset_filter").hide();
            }
            var wiget_frames = $("#views-exposed-form-arts-page .views-exposed-widget");
            for (var i = 0; i < wiget_frames.length; ++i) {
                var wf = $(wiget_frames[i]);
                var fv = wf.find('select');
                var fv = fv.val();
                if (fv != null) {
                    wf.find('.drop_filter').show();
                } else {
                    wf.find('.drop_filter').hide();
                }
            }
        }, 500);
        setTimeout(resizeEvent, 500);
        $("#count").spinner();
        setTableGreed();
        $('.dynamic_select').bind('change', function () {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
        jQuery("#tabs").tabs();
    });
    function validateForms(forms, params) {
        for (var i = 0; i < forms.length; ++i) {
            next_form = $(forms[i]);
            next_form.validate({
                submitHandler: function (form) {
                    //берем из формы метод передачи данных
                    var m_method = next_form.attr('method');
                    //получаем адрес скрипта на сервере, куда нужно отправить форму
                    var m_action = next_form.attr('action');
                    //получаем данные, введенные пользователем в формате input1=value1&input2=value2...,
                    //то есть в стандартном формате передачи данных формы
                    var m_data = next_form.serialize();
                    m_data = m_data + "&ajax=1";
                    //var mes = $('#block-webform-client-block-79 form');

                    $.ajax({
                        type: m_method,
                        url: m_action,
                        data: m_data,
                        complete: function (result) {
                            var cont = '';
                            cont = result.responseText
                            if (params !== undefined && params.redirect !== undefined) {
                                window.location.replace('/' + params.redirect);
                            } else {
                                jQuery.fancybox.open(
                                    {
                                        content: cont, //"<h2>&nbsp;</h2><div class='funcy_cnt'><h3>Спасибо за заявку!</h3><div class='text'>Мы перезвоним вам в ближайшее рабочее время (пн-пт с 9.00 до 18.00)</div></div>",
                                        wrapCSS: 'back_fan_form mess_fancy',
                                        minWidth: 350
                                    }
                                );
                            }
                        }
                    });
                    //mes.html('<h3>Подождите...</h3>');
                },
                onfocusout: false,
                onkeyup: false,
                onclick: false
            });
        }
    }

    function resizeEvent() {
        var w = $("#post-content").width(), cnt = 4;
        if (w < 860) {
            cnt = 3;
        }
        $(".caroufredsel_wrapper .product_frame").width((w / cnt) - 29);
    }

    var waitForFinalEvent = (function () {
        var timers = {};
        return function (callback, ms, uniqueId) {
            if (!uniqueId) {
                uniqueId = "Don't call this twice without a uniqueId";
            }
            if (timers[uniqueId]) {
                clearTimeout(timers[uniqueId]);
            }
            timers[uniqueId] = setTimeout(callback, ms);
        };
    })();

    function setProductSlider() {
        $('.item_photo_text .screen').click(function () {
            $($(".trumb_frame a")[0]).click();
        });
        $(".fancybox").fancybox();
    }

    function setBuyButton() {
        $('.add_to_cat').click(function () {
            var product_frame = $(this).parents('.product_frame');
            var product_link = product_frame.find('.link'),
                product_img = product_frame.find('.image_frame'),
                product_discr = product_frame.find('.discript');

            var str = $("<div class='buy'></div>");
            str.append(product_img.clone());
            str.append(product_link.clone());
            str.append(product_discr.clone());
            str.append("<a class='mes_check' href='/checkout'><span>Оформить заказ</span></a>");

            var str, frame, instr;
            frame = $('<div class="buy_frame"><h2>' + Drupal.t('Товар добавлен в корзину') + '</h2></div>');
            str = $("<div class='buy'></div>");
            str.append(product_img.clone().addClass('image_frame'));
            instr = $("<div class='instr'></div>");
            instr.append(product_link.clone());
            instr.append(product_discr.clone().addClass('discript'));
            instr.append("<div class='actions'><a class='cloze_fancy' href='#'>" + Drupal.t('Продолжить покупки') + "</a> <a class='mes_check' href='/checkout'><span>Оформить заказ</span></a></div>");
            frame.append(str.append(instr));
            var qnt = $('#count').val();
            jQuery.fancybox.open(
                {
                    content: frame,
                    scrolling: 'no',
                    wrapCSS: 'back_fan_form buy_link'
                }
            );
            var offset = $(this).offset();
            $('.ui-dialog').offset({ top: offset.top + 40, left: offset.left });
            //return false;
            var sku = $(this).data('id');
            $.ajax(
                {
                    url: "/custom_ajax",
                    data: { type: "add_to_cart", sku: sku }
                }
            ).done(function (rez) {
                    var rezult = jQuery.parseJSON(rez);
                    $("#block-commerce-cart-cart .content").html(rezult.card);
                    setCardDeleteActions();
                    setCardActions();
                });
            return false;
        });
        $('.buy_button').click(function () {
            var product_frame = $(this).parents('.product_frame');

            var product_name = $($('.page-title')[0]),
                product_img = $($('.screen')[0]),
                product_discr = $($('.item_info')[0]);


            var str, frame, instr;
            frame = $('<div class="buy_frame"><h2>' + Drupal.t('Товар добавлен в корзину') + '</h2></div>');
            str = $("<div class='buy'></div>");
            str.append(product_img.clone().addClass('image_frame'));
            instr = $("<div class='instr'></div>");
            instr.append('<div>' + product_name.clone().text() + '</div>');
            instr.append(product_discr.clone().addClass('discript'));
            instr.append("<div class='actions'><a class='cloze_fancy' href='#'>" + Drupal.t('Продолжить покупки') + "</a> <a class='mes_check' href='/checkout'><span>Оформить заказ</span></a></div>");
            frame.append(str.append(instr));
            var qnt = $('#count').val();
            jQuery.fancybox.open(
                {
                    content: frame,
                    scrolling: 'no',
                    wrapCSS: 'back_fan_form buy_link'
                }
            );
            var offset = $(this).offset();
            $('.ui-dialog').offset({ top: offset.top + 40, left: offset.left });
            //return false;
            var sku = $(this).data('id');
            $.ajax(
                {
                    url: "/custom_ajax",
                    data: { type: "add_to_cart", sku: sku, qnt: qnt }
                }
            ).done(function (rez) {
                    var rezult = jQuery.parseJSON(rez);
                    $("#block-commerce-cart-cart .content").html(rezult.card);
                    setCardDeleteActions();
                    setCardActions();
                });
            return false;
        });
    }

    function inputDefaultValue() {
        var inputs = $(".fancybox-inner .form-text, .fancybox-inner textarea, #block-search-form .form-text");
        inputs.live("focus", function () {
                var input = $(this);
                if (input.val() == input.data('dv')) {

                    //input.val('');
                    //input.removeClass('default_val');
                }
            }
        );
        inputs.live('keydown', function (key) {
            var input = $(this);
            //alert('asdas');
            if (input.val() == input.data('dv')) {

                input.val('');
                input.removeClass('default_val');
            }
        });
        inputs.live('blur', function () {
            var input = $(this);
            if (input.val() == '') {
                input.val(input.data('dv'));
                input.addClass('default_val');
            }
        });
        $('input[type="submit"]').live('click', function () {
            var ipts = $(this).parents('form').find('.form-text, textarea');
            for (var i = 0; i < ipts.length; ++i) {
                var input = $(ipts[i]);
                if (input.val() == input.data('dv')) {
                    input.val('');
                    input.removeClass('default_val');
                }
            }
        })
        var inputs = $(".form-text, textarea");
        for (var i = 0; i < inputs.length; ++i) {
            var inp = $(inputs[i]);
            if (inp.val()) {
                inp.attr('data-dv', inp.val());
                inp.addClass('default_val');
            }

        }
    }

    function setCardDeleteActions() {
        $("#block-commerce-cart-cart .delete-line-item").click(
            function () {
                var qnts = $("#block-commerce-cart-cart .views-field-edit-quantity input")
                    , arr = [];
                for (var i = 0; i < qnts.length; ++i) {
                    var qnt = $(qnts[i]);
                    arr.push(qnt.val());
                }
                var inp = $(this);
                var str = inp.attr('id').replace('edit-edit-delete-', '');
                var num = parseInt(str);
                arr[num] = 0;
                $.ajax(
                    {
                        url: "/custom_ajax",
                        data: { type: "card_count", qnt: arr }
                    }
                ).done(function (rez) {
                        var rezult = jQuery.parseJSON(rez);
                        $("#block-commerce-cart-cart .content").html(rezult.card);
                        setCardDeleteActions();
                        setCardActions();
                    });
                return false;
            }
        );
    }

    function setCardActions() {
        /*$("#block-commerce-cart-cart .line-item-summary .links").append($('<li class="refresh_count"><a href="#"><span>Обновить</span></a></li>'))


         $("#block-commerce-cart-cart .refresh_count a").click(function(){
         var qnts = $("#block-commerce-cart-cart .views-field-edit-quantity input")
         , arr = [];
         for(var i = 0; i < qnts.length; ++i){
         var qnt = $(qnts[i]);
         arr.push(qnt.val());
         }
         $.ajax(
         {
         url: "/custom_ajax",
         data: { type: "card_count", qnt: arr }
         }
         ).done(function( rez ) {
         var rezult =  jQuery.parseJSON(rez);
         $("#block-commerce-cart-cart .content").html(rezult.card);
         setCardDeleteActions();
         setCardActions();
         });
         });*/

    }

    function setUserLink() {
        jQuery("#block-webform-client-block-41").hide();
        var clone = jQuery("#block-webform-client-block-41").clone();
        $('.field-name-field-user-button').click(function () {
            var header = $.trim($('h1').text());
            clone.find('#edit-submitted-naimenovanie-uslugi').val(header);
            jQuery.fancybox.open(
                {
                    content: clone,
                    scrolling: 'no',
                    wrapCSS: 'back_fan_form user_link'
                }
            );
            validateForms($(".back_fan_form form"));
            return false;
        });
    }

    function setActionLink() {
        jQuery("#block-webform-client-block-41").hide();
        var clone = jQuery("#block-webform-client-block-41").clone();
        $('a.zak_serv').click(function () {
            var header = $.trim($(this).parents('.views-row').find('.views-field-title').text());
            clone.find('#edit-submitted-naimenovanie-uslugi').val(header);
            jQuery.fancybox.open(
                {
                    content: clone,
                    scrolling: 'no',
                    wrapCSS: 'back_fan_form action_link'
                }
            );
            validateForms($(".back_fan_form form"));
            return false;
        });
        jQuery("#block-webform-client-block-34").hide();
        var clone_kp = jQuery("#block-webform-client-block-34").clone();
        $('a.kp_serv').click(function () {
            var header = $.trim($(this).parents('.views-row').find('.views-field-title').text());
            clone_kp.find('#edit-submitted-naimenovanie-tovara-zkp').val(header);
            jQuery.fancybox.open(
                {
                    content: clone_kp,
                    scrolling: 'no',
                    wrapCSS: 'back_fan_form kp_link'
                }
            );
            validateForms($(".back_fan_form form"));
            return false;
        });
    }

    function setTableGreed() {
        var tables = $('table');
        for (var i = 0; i < tables.length; ++i) {
            var table = $(tables[i]);
            var rows = table.find('tr');
            for (var j = 0; j < rows.length; ++j) {
                var row = $(rows[j]);
                var clas = 'odd';
                if (j % 2 == 0) {
                    clas = 'even';
                }
                row.addClass(clas);
            }
        }
    }

    function setKPFancy() {

        jQuery("#block-webform-client-block-34").hide();
        var clone = jQuery("#block-webform-client-block-34").clone();
        jQuery("a.kp").click(function () {
            var header = $('.page-title').text();
            clone.find('#edit-submitted-naimenovanie-tovara-zkp').val(header);
            jQuery.fancybox.open(
                {
                    content: clone,
                    scrolling: 'no',
                    wrapCSS: 'back_fan_form kp_item_link'
                }
            );
            validateForms($(".back_fan_form form"));
            return false;
        });
    }

    function init(map) {
        var myMap = new ymaps.Map(map, {
            center: [0.753994, 0.622093],
            zoom: 9,
            behaviors: ['default', 'scrollZoom']
        });
        ymaps.geocode('г. Москва, ул. Большая Тульская, д. 43', {
            results: 1
        }).then(function (res) {
                // Выбираем первый результат геокодирования.
                var firstGeoObject = res.geoObjects.get(0),
                // Координаты геообъекта.
                    coords = firstGeoObject.geometry.getCoordinates(),
                // Область видимости геообъекта.
                    bounds = firstGeoObject.properties.get('boundedBy');

                // Добавляем первый найденный геообъект на карту.
                myMap.geoObjects.add(firstGeoObject);
                // Масштабируем карту на область видимости геообъекта.
                myMap.setBounds(bounds, {
                    checkZoomRange: true // проверяем наличие тайлов на данном масштабе.
                });
            });
    }

    function setSitemapFuncybox() {
        $(".sheme_proezd").click(
            function () {
                jQuery.fancybox.open(
                    {
                        content: '<div style="width:100%; height: 100%;" id="map"></div>',
                        autoSize: false,
                        wrapCSS: 'sitemap_funcy',
                        width: "80%",
                        scrolling: 'no',
                        height: "80%"
                    }
                );
                init('map');
                return false;
            }
        );
    }

    function setLogonFuncybox() {
        jQuery("#block-user-login").hide();
        var clone = jQuery("#block-user-login");//	.clone();
        jQuery("#block-block-1 .login").click(function () {
            jQuery.fancybox.open(
                {
                    content: clone,
                    scrolling: 'no',
                    wrapCSS: 'back_fan_form user_login'
                }
            );
            validateForms($(".back_fan_form form"), {redirect: 'user'});
            return false;
        });
    }

    function setReviewFuncybox() {
        jQuery("#review_form").hide();
        var clone = jQuery("#review_form");//	.clone();
        jQuery(".write_review").click(function () {
            jQuery.fancybox.open(
                {
                    content: clone,
                    scrolling: 'no',
                    wrapCSS: 'back_fan_form review_link',
                    minWidth: 350
                }
            );
            validateForms($(".back_fan_form form"));
            return false;
        });
    }

    function setFilterFunctionalyty() {
        $("#brands_filter").multiselect({
        });
        $('.init_filter').click(
            function () {
                var brands = $('#brands_filter').val();
                $('#brands_filter :selected').each(function (i, selected) {
                    brands[i] = $(selected).val();
                });
                if (brands.length) {
                    if (brands.length == 1) {
                        url_arr_query.mark = brands[0];
                    } else {
                        url_arr_query.mark = brands;
                    }
                }
                var q = url_base + $.param(url_arr_query);
                window.location = q;

                return false;
            }
        );
        $('.reset_filter').click(function () {
            //$('#brands_filter').val('');
            $('#brands_filter').multiselect("uncheckAll");
            return false;
        });

    }

    function ForeColumnHeight(items) {
        items.css({'display': 'block', height: 'auto'});
        for (var i = 0; i + 3 < items.length; i += 4) {
            var left = jQuery(items[i]);
            var center = jQuery(items[i + 1]);
            var center2 = jQuery(items[i + 2]);
            var right = jQuery(items[i + 3]);
            var max = Math.max(left.height(), center.height(), center2.height(), right.height());
            left.height(max);
            center.height(max);
            center2.height(max);
            right.height(max);
        }
    }

    function ThreeColumnHeight(items) {
        for (var i = 0; i + 2 < items.length; i += 3) {
            var left = jQuery(items[i]);
            var center = jQuery(items[i + 1]);
            var right = jQuery(items[i + 2]);
            var max = Math.max(left.height(), center.height(), right.height());
            left.height(max);
            center.height(max);
            right.height(max);
        }
    }

    function setXitsCarusel() {
        var xit_content = $("#block-custom-hit-product .content"),
            frame = $("#block-custom-hit-product");
        xit_content.after("<div class='arrs'><div class='la'></div><div class='ra'></div></div>");
        xit_content.carouFredSel({
            scroll: {
                items: 1
            },
            width: 1008,
            //height: 420,
            auto: false,
            prev: frame.find('.la'),
            next: frame.find('.ra')
        });
    }

    function setSpecCarusel() {
        var xit_content = $("#block-custom-spec-product .content"),
            frame = $("#block-custom-spec-product");
        xit_content.after("<div class='arrs'><div class='la'></div><div class='ra'></div></div>");
        xit_content.carouFredSel({
            scroll: {
                items: 1
            },
            width: 1008,
            auto: false,
            prev: frame.find('.la'),
            next: frame.find('.ra')
        });
    }

    function setBrandsCarusel() {
        var brands_content = $("#block-views-brands-block .view-content"),
            frame = $("#block-views-brands-block");
        brands_content.after("<div class='arrs'><div class='la'></div><div class='ra'></div></div>");
        brands_content.carouFredSel({
            scroll: {
                items: 1
            },
            auto: false,
            prev: frame.find('.la'),
            next: frame.find('.ra')
        });
    }

    function setCallbackFancybox() {
        jQuery("#block-webform-client-block-31").hide();
        var clone = jQuery("#block-webform-client-block-31").clone();
        jQuery(".mail_collback").click(function () {
            jQuery.fancybox.open(
                {
                    content: clone,
                    scrolling: 'no',
                    wrapCSS: 'back_fan_form call_back_link'
                }
            );
            validateForms($(".back_fan_form form"));
            return false;
        });
    }

    function setCallFancybox() {
        jQuery("#block-webform-client-block-26").hide();
        var clone = jQuery("#block-webform-client-block-26").clone();
        jQuery(".call_func").click(function () {
            jQuery.fancybox.open(
                {
                    content: clone,
                    scrolling: 'no',
                    wrapCSS: 'back_fan_form call_form_link'
                }
            );
            validateForms($(".back_fan_form form"));
            return false;
        });
    }

    function setPriceFuncybox() {
        jQuery("#block-webform-client-block-62").hide();
        var clone = jQuery("#block-webform-client-block-62").clone();
        jQuery(".know_price").click(function () {
            clone.find('#edit-submitted-interesuyushchiy-tovar-yts').val($(".page-title").text());
            jQuery.fancybox.open(
                {
                    content: clone,
                    scrolling: 'no',
                    wrapCSS: 'back_fan_form price_form_link'
                }
            );
            validateForms($(".back_fan_form form"));
            return false;
        });
    }

    function setDocFuncybox() {
        jQuery("#block-webform-client-block-63").hide();
        var clone = jQuery("#block-webform-client-block-63").clone();
        jQuery(".call_dock").click(function () {
            clone.find('#edit-submitted-interesuyushchiy-tovar-zdoc').val($(".page-title").text());
            jQuery.fancybox.open(
                {
                    content: clone,
                    scrolling: 'no',
                    wrapCSS: 'back_fan_form price_form_link'
                }
            );
            validateForms($(".back_fan_form form"));
            return false;
        });
    }
})(jQuery);