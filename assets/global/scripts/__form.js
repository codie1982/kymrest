var form_action = function () {
    var url = window.location.href;
    var a = document.createElement('a');
    a.href = url;
    var hostname = "https://" + a.hostname + "/";

    var randomPassword = function (length) {
        var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
        var pass = "";
        for (var x = 0; x < length; x++) {
            var i = Math.floor(Math.random() * chars.length);
            pass += chars.charAt(i);
        }
        return pass;
    }
    var validateEmail = function (email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    $('[data-form-data="name"]').on("change keyup", function () {
        var name = $(this).val()
        if (name == "") {
            $(this).parent().find(".danger_text").html("İsim Soy İsim Alanını Boş Bırakmayınız")
        } else {
            $(this).parent().find(".help").each(function () {
                $(this).html("");
            })
        }
    })
    $('[data-form-data="email"]').on("change keyup", function () {
        var email = $(this).val()
        if (email == "") {
            $(this).parent().find(".danger_text").html("Mail Alanını Boş Bırakmayınız")
        } else {
            $(this).parent().find(".help").each(function () {
                $(this).html("");
            })
            if (validateEmail(email)) {
                $(this).parent().find(".complete_text").html("Mail Adresi Kullanılabilir")
            } else {
                $(this).parent().find(".danger_text").html("Mail Adresi Kullanılamaz")
            }
        }
    })
    $('[data-form-data="password"]').on("change keyup", function () {
        var password = $(this).val()
        if (password == "") {
            $(this).parent().find(".danger_text").html("Şifre Alanını Boş Bırakmayınız")
        } else {
            $(this).parent().find(".help").each(function () {
                $(this).html("");
            })
            if (password.length >= 8) {
                $(this).parent().find(".complete_text").html("Bu Şifre Uygun")
            } else {
                $(this).parent().find(".danger_text").html("Şifreniz En az 8 Karakretli Olmalıdır")
            }
        }

    })
    var viewpassword = function () {
        $('[data-form-data="viewpassword"]').on("click", function (e) {
            var type = $(this).parents("form").find('[data-form-data="password"]').attr("type");
            if (type == "password") {
                $(this).parents("form").find('[data-form-data="password"]').attr("type", "name");
                $(this).html("Şifreyi Sakla");
            } else {
                $(this).parents("form").find('[data-form-data="password"]').attr("type", "password");
                $(this).html("Şifreyi Göster");
            }
        })
    }

    $('[data-form-data="makepassword"]').on("click", function () {
        $(this).parents("form").find('[data-form-data="password"]').val(randomPassword(8));
    })

    var send_xhr = function () {
        var form = $('[data-send="xhr"]');
        alert(form)
        $('[data-form="login_form"]').submit(function (e) {
            e.preventDefault();
            var $this = $(this)
            var scriptURL = $(this).attr("action");

            $.ajax({type: "post",
                url: scriptURL,
                data: {"form_data": $this.serialize()},
                dataType: "json",
                beforeSend: function () {
                    toastr["warning"]("Kontrol Ediliyor")
                },
                success: function (data) {
                    if (data.sonuc) {
                        toastr["success"](data.msg)
                        if (data.redirect) {
                            window.location.href = hostname + data.redirect
                        }
                    } else {
                        toastr["error"](data.msg)
                        if (data.redirect) {
                            window.location.href = hostname + data.redirect
                        }
                    }
                }
            });
        })
    }

    var make_job = function () {
        var redirect;
        $(".btn-product-add-shopping-card").on("click", function (e) {
            redirect = "---";
        })
        $(".btn-product-fast-shopping").on("click", function (e) {
            redirect = $(this).data("redirect");
        })

        $('[data-form="new_job"]').submit(function (e) {
            e.preventDefault()
            var $this = $(this)
            var update_icon = $('[name="update_icon"]')
            var scriptURL = $this.attr("action");
            $.ajax({type: "post",
                url: scriptURL,
                data: {"form_data": $this.serialize(), "redirect": redirect},
                dataType: "json",
                beforeSend: function () {
                    toastr["warning"]("Kontrol Ediliyor")
                },
                success: function (data) {
                    if (data.sonuc) {
                        toastr["success"](data.msg)
                        if (data.redirect) {
                            window.location.href = hostname + data.redirect
                        }

                        if (typeof update_icon !== "undefined") {
                            var icon_len = $(".shopping_card_count").length
                            var icon = $(".shopping_card_count")
                            var basket_icon = $(".basket-icon")
                            console.log(data)

                            var shopping_card_descripton = $(".shopping_card_descripton"), product_list = "";
                            var shopping_card_footer = $(".shopping_card_footer")
                            for (var i = 0; i < data.shopping_card_info.length; i++) {
                                product_list += '<ul>\n\
                                <li> <img src="' + data.shopping_card_info[i].img + '" width="60" height="60" alt="' + data.shopping_card_info[i].product_name + '"/></li>\n\
                                <li><div class="shopping_card_item_text">' + data.shopping_card_info[i].product_name + '</div>\n\
                                    <div class="shopping_card_item_code">Ürün Kodu: ' + data.shopping_card_info[i].product_code + '</div>\n\
                                    <div class="shopping_card_item_price">' + data.shopping_card_info[i].product_price + ' ' + data.shopping_card_info[i].product_unit + '</div>\n\
                                </li>\n\
                                <li>' + data.shopping_card_info[i].product_amount + ' Adet</li>\n\
                                </ul>'

                            }
                            shopping_card_descripton.html(product_list)
                            if (icon_len !== 0) {
                                //Varsa
                                icon.html('<span>' + data.job_count + '</span>')
                                $("#header_job_price").html(data.job_price + ' ' + data.job_unit)
                                $("#header_cargo_price").html(data.job_cargo_price + ' ' + data.job_unit)
                                $("#header_total_price").html(data.job_general_total_price + ' ' + data.job_unit)
                                $(".shopping_card_menu").addClass("open")
                            } else {
                                //Yoksa
                                basket_icon.append('<div class="shopping_card_count"><span>' + data.job_count + '</span></div>')
                                shopping_card_footer.html('<div class="row">\n\
                                        <div class="col-sm-6"><div class="shopping_card_price_title">Sepet Tutarı</div></div>\n\
                                        <div class="col-sm-6"><div id="header_job_price"  class="shopping_card_price">' + data.job_price + ' ' + data.job_unit + '</div> </div>\n\
                                    </div>\n\
                                    <div class="row">\n\
                                        <div class="col-sm-6"><div class="shopping_card_price_title">Kargo Tutarı</div></div>\n\
                                        <div class="col-sm-6"><div id="header_cargo_price" class="shopping_card_price">' + data.job_cargo_price + ' ' + data.job_unit + '</div></div>\n\
                                    </div>\n\
                                    <div class="row">\n\
                                        <div class="col-sm-6"><div class="shopping_card_total_title">KDV DAHİL TOPLAM</div></div>\n\
                                        <div class="col-sm-6"><div id="header_total_price" class="shopping_card_total_price">' + data.job_general_total_price + ' ' + data.job_unit + '</div></div>\n\
                                    </div>')
                                $(".shopping_card_menu").addClass("open")

                            }




                            /*
                             $data["job_price"] = number_format($job_price["total"], 2);
                             $data["job_unit"] = strtoupper($job_price["unit"]);
                             $data["job_cargo_price"] = number_format($job_cargo_price["cargo"], 2);
                             $data["job_extra_price"] = number_format($job_extra_price["extra"], 2);
                             $data["job_discount_price"] = number_format($job_discount_price["discount"], 2);
                             $data["job_tax_price"] = number_format($job_tax_price["tax"], 2);
                             $data["job_general_total_price"] = number_format($job_total_jobprice["total"], 2);
                             */



                        }
                    } else {
                        toastr["error"](data.msg)
                        if (data.redirect) {
                            window.location.href = hostname + data.redirect
                        }
                    }
                }
            });
        })

        $('[data-form="new_poster"]').submit(function (e) {
            e.preventDefault();
            var $this = $(this)
            var update_icon = $('[name="update_icon"]')
            var poster_width_input = $('input[name="poster_width"]');
            var poster_height_input = $('input[name="poster_height"]');
            var poster_width = $('input[name="poster_width"]').val();
            var poster_height = $('input[name="poster_height"]').val();
            if (poster_width == "" || poster_width == 0 || poster_height == "" || poster_height == 0) {
                toastr["error"]("Boş Alan Bırakmayınız")
                poster_width_input.css({"border-color": "red"})
                poster_height_input.css({"border-color": "red"})
            } else {
                poster_width_input.css({"border-color": "#b09371"})
                poster_height_input.css({"border-color": "#b09371"})
                var scriptURL = $this.attr("action");
                $.ajax({type: "post",
                    url: scriptURL,
                    data: {"form_data": $this.serialize(), "redirect": redirect},
                    dataType: "json",
                    beforeSend: function () {
                        toastr["warning"]("Kontrol Ediliyor")
                    },
                    success: function (data) {
                        if (data.sonuc) {
                            toastr["success"](data.msg)
                            if (data.redirect) {
                                window.location.href = hostname + data.redirect
                            }

                            if (typeof update_icon !== "undefined") {
                                var icon_len = $(".shopping_card_count").length
                                var icon = $(".shopping_card_count")
                                var basket_icon = $(".basket-icon")
                                console.log(data)

                                var shopping_card_descripton = $(".shopping_card_descripton"), product_list = "";
                                var shopping_card_footer = $(".shopping_card_footer")
                                for (var i = 0; i < data.shopping_card_info.length; i++) {
                                    product_list += '<ul>\n\
                                <li> <img src="' + data.shopping_card_info[i].img + '" width="60" height="60" alt="' + data.shopping_card_info[i].product_name + '"/></li>\n\
                                <li><div class="shopping_card_item_text">' + data.shopping_card_info[i].product_name + '</div>\n\
                                    <div class="shopping_card_item_code">Ürün Kodu: ' + data.shopping_card_info[i].product_code + '</div>\n\
                                    <div class="shopping_card_item_price">' + data.shopping_card_info[i].product_price + ' ' + data.shopping_card_info[i].product_unit + '</div>\n\
                                </li>\n\
                                <li>' + data.shopping_card_info[i].product_amount + ' Adet</li>\n\
                                </ul>'

                                }
                                shopping_card_descripton.html(product_list)
                                if (icon_len !== 0) {
                                    //Varsa
                                    icon.html('<span>' + data.job_count + '</span>')
                                    $("#header_job_price").html(data.job_price + ' ' + data.job_unit)
                                    $("#header_cargo_price").html(data.job_cargo_price + ' ' + data.job_unit)
                                    $("#header_total_price").html(data.job_general_total_price + ' ' + data.job_unit)
                                    $(".shopping_card_menu").addClass("open")
                                } else {
                                    //Yoksa
                                    basket_icon.append('<div class="shopping_card_count"><span>' + data.job_count + '</span></div>')
                                    shopping_card_footer.html('<div class="row">\n\
                                        <div class="col-sm-6"><div class="shopping_card_price_title">Sepet Tutarı</div></div>\n\
                                        <div class="col-sm-6"><div id="header_job_price"  class="shopping_card_price">' + data.job_price + ' ' + data.job_unit + '</div> </div>\n\
                                    </div>\n\
                                    <div class="row">\n\
                                        <div class="col-sm-6"><div class="shopping_card_price_title">Kargo Tutarı</div></div>\n\
                                        <div class="col-sm-6"><div id="header_cargo_price" class="shopping_card_price">' + data.job_cargo_price + ' ' + data.job_unit + '</div></div>\n\
                                    </div>\n\
                                    <div class="row">\n\
                                        <div class="col-sm-6"><div class="shopping_card_total_title">KDV DAHİL TOPLAM</div></div>\n\
                                        <div class="col-sm-6"><div id="header_total_price" class="shopping_card_total_price">' + data.job_general_total_price + ' ' + data.job_unit + '</div></div>\n\
                                    </div>')
                                    $(".shopping_card_menu").addClass("open")

                                }




                                /*
                                 $data["job_price"] = number_format($job_price["total"], 2);
                                 $data["job_unit"] = strtoupper($job_price["unit"]);
                                 $data["job_cargo_price"] = number_format($job_cargo_price["cargo"], 2);
                                 $data["job_extra_price"] = number_format($job_extra_price["extra"], 2);
                                 $data["job_discount_price"] = number_format($job_discount_price["discount"], 2);
                                 $data["job_tax_price"] = number_format($job_tax_price["tax"], 2);
                                 $data["job_general_total_price"] = number_format($job_total_jobprice["total"], 2);
                                 */



                            }
                        } else {
                            toastr["error"](data.msg)
                            if (data.redirect) {
                                window.location.href = hostname + data.redirect
                            }
                        }
                    }
                });
            }

        })
    }

    return {
//main function to initiate the module
        init: function () {
            send_xhr()
            randomPassword()
            validateEmail()
            viewpassword()
            make_job()

        }
    };
}();
jQuery(document).ready(function () {
    form_action.init(); // init metronic core componets
});