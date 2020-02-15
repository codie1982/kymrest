$.fn.product_table = function (options) {
    var $this = this;
    var defaults = {
        html: false,
        product_type: "all",
        product: "all",
        start: 0,
        end: 10,
        show: 10,
        category: "all",
        condition: "all",
        order: "desc",
        filter: false,
    }
    var settings = $.extend({}, defaults, options);
    //console.log(settings)
//    var _start = settings.start,
//            _end = settings.end,
//            _html = settings.html,
//            _show = settings.show;

    if (settings.html) {
        addTable();
    }

    function addTable() {


        if (settings.product_type == "all") {
            var scriptURL = "/xhr/sendproduct/getproducttable";
        } else if (settings.product_type == "jobItem") {
            var scriptURL = "/xhr/sendproduct/getjobproducttable";
        }
        //console.log(settings)
        $('[name="table_settings"]').val(JSON.stringify(settings))
        // let param = $(".table_parameter").append($('[name="table_settings"]').val())
        //console.log(JSON.parse(param))

        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "product_type": settings.product_type,
                "product": settings.product,
                "start": settings.start,
                "end": settings.end,
                "show": settings.show,
                "category": settings.category,
                "condition": settings.condition,
                "order": settings.order,
                "filter": settings.filter,
            },
            dataType: "json",
            beforeSend: function () {

                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {

                $("body").find(".waiting_screen").fadeOut()
                $this.html(data.table)
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim
                    if (settings.product_type == "jobItem") {
                        $('[data-product="product_item"]').TouchSpin({
                            min: 0,
                            max: 100,
                            boostat: 10,
                            verticalbuttons: false,
                            verticalupclass: 'glyphicon glyphicon-plus',
                            verticaldownclass: 'glyphicon glyphicon-minus'
                        });
                        $('[data-product="product_item"]').on('touchspin.on.startupspin', function () {
                            var amount = $(this).val()
                            var random = $(this).parents("tr").find('[name="product_random[]"]').val();
                            var total_price = $(this).parents("tr").find('[name="product_total_price[' + random + ']"]').val();
                            var ntotal_price = parseInt(total_price) * parseInt(amount)
                            $(this).parents("tr").find('[name="product_total_price_for_job[' + random + ']"]').val(ntotal_price);
                            $(this).parents("tr").find('[data-product="total_price"]').html(ntotal_price);
                            //data-job="total_job_price"
                            var total_job_price = 0;
                            var random = "";
                            $(this).parents("table").find("tr").each(function () {
                                random = $(this).find('[name="product_random[]"]').val()
                                if (typeof random !== "undefined") {
                                    console.log($(this).find('[name="product_total_price_for_job[' + random + ']"]').val())
                                    total_job_price += parseInt($(this).find('[name="product_total_price_for_job[' + random + ']"]').val());
                                }

                            })

                            $("body").find('[data-job="total_job_price"]').html(total_job_price)
                            $("body").find('[data-job="total_job_price_unit"]').html("tl")
                        });
                        $('[data-product="product_item"]').on('touchspin.on.startdownspin', function () {
                            var amount = $(this).val()
                            var random = $(this).parents("tr").find('[name="product_random[]"]').val();
                            var total_price = $(this).parents("tr").find('[name="product_total_price[' + random + ']"]').val();
                            var ntotal_price = parseInt(total_price) * parseInt(amount)
                            $(this).parents("tr").find('[name="product_total_price_for_job[' + random + ']"]').val(ntotal_price);
                            $(this).parents("tr").find('[data-product="total_price"]').html(ntotal_price);
                            //data-job="total_job_price"
                            var total_job_price = 0;
                            var random = "";
                            $(this).parents("table").find("tr").each(function () {
                                random = $(this).find('[name="product_random[]"]').val()
                                if (typeof random !== "undefined") {
                                    console.log($(this).find('[name="product_total_price_for_job[' + random + ']"]').val())
                                    total_job_price += parseInt($(this).find('[name="product_total_price_for_job[' + random + ']"]').val());
                                }
                            })

                            $("body").find('[data-job="total_job_price"]').html(total_job_price)
                            $("body").find('[data-job="total_job_price_unit"]').html("tl")
                        });
                    }


                    $('[data-product="copy_product"]').off()
                    $('[data-product="copy_product"]').on("click", function () {
                        var btn = $(this)
                        var product_seccode = btn.data("product_seccode");
                        copyProductInfo(product_seccode)
                    }
                    )

                    $('[data-product="edit_product"]').off()
                    $('[data-product="edit_product"]').on("click", function () {
                        var btn = $(this)
                        var product_seccode = btn.data("product_seccode");
                        editProductInfo(product_seccode)
                    }
                    )

                    $('[data-product="remove_product"]').off()
                    $('[data-product="remove_product"]').on("click", function () {
                        var product_seccode = $(this).data("product_seccode");
                        var btn = $(this);
                        removeProduct(product_seccode, btn)
                    }
                    )

                    $('[data-product="ofline_product"]').off()
                    $('[data-product="ofline_product"]').on("click", function () {
                        var product_seccode = $(this).data("product_seccode");
                        var btn = $(this);
                        ofline_product(product_seccode, btn)
                    }
                    )

                    $('[data-product="online_product"]').off()
                    $('[data-product="online_product"]').on("click", function () {
                        var product_seccode = $(this).data("product_seccode");
                        var btn = $(this);
                        online_product(product_seccode, btn)
                    }
                    )
                    $('[data-product="show_page"]').off()
                    $('[data-product="show_page"]').on("change", function () {
                        var $this = $(this)
                        page_selected($this)
                    });
                    $('[data-product="show_result"]').off();
                    $('[data-product="show_result"]').on("change", function () {
                        var $this = $(this)
                        show_count($this)
                    });
                    $('[data-product="page_number"]').on("click", "button", function () {
                        var $this = $(this)
                        page_number($this)
                    })
                    $(".checkboxes").off()
                    $(".checkboxes").on("change", function () {
                        var $this = $(this)
                        checked($this)
                    })
                    $('[data-table="allchecked"]').off()
                    $('[data-table="allchecked"]').on("change", function () {
                        var $this = $(this)
                        allchecked($this)
                    })
                    $("#allSelected").off()
                    $("#allSelected").on("click", function () {
                        var $this = $(this)
                        allProductSelected($this)
                    })

                    $('[data-product="main_product"]').on("click", function () {
                        var $this = $(this)
                        var product_seccode = $this.data("product_seccode")
                        add_main_poruduct_list(product_seccode, $this)
                    })

                    $('[data-product="public"]').on("click", function () {
                        var product_seccode = $(this).data("product_seccode");
                        var btn = $(this);
                        var place = $this.data("place");
                        product_public(product_seccode, btn, place)
                    })

                } else {
                    toastr["error"](data.msg)
                }
            }
        });
        $('[data-product="copy_product"]').off()
        $('[data-product="copy_product"]').on("click", function () {
            var btn = $(this)
            var product_seccode = btn.data("product_seccode");
            copyProductInfo(product_seccode)
        }
        )
        $('[data-product="edit_product"]').off()
        $('[data-product="edit_product"]').on("click", function () {
            var btn = $(this)
            var product_seccode = btn.data("product_seccode");
            editProductInfo(product_seccode)
        }
        )

        $('[data-product="remove_product"]').off()
        $('[data-product="remove_product"]').on("click", function () {
            var product_seccode = $(this).data("product_seccode");
            var btn = $(this);
            removeProduct(product_seccode, btn)
        }
        )

        $('[data-product="ofline_product"]').off()
        $('[data-product="ofline_product"]').on("click", function () {
            var product_seccode = $(this).data("product_seccode");
            var btn = $(this);
            ofline_product(product_seccode, btn)
        }
        )

        $('[data-product="online_product"]').off()
        $('[data-product="online_product"]').on("click", function () {
            var product_seccode = $(this).data("product_seccode");
            var btn = $(this);
            online_product(product_seccode, btn)
        }
        )

        $(".checkboxes").on("change", function () {
            var $this = $(this)
            checked($this)
        })
        $('[data-table="allchecked"]').on("change", function () {
            var $this = $(this)
            allchecked($this)
        })
        $("#allSelected").off();
        $("#allSelected").on("click", function () {
            var $this = $(this)
            allProductSelected($this)
        })

    }
    $('[data-product="copy_product"]').off()
    $('[data-product="copy_product"]').on("click", function () {
        var btn = $(this)
        var product_seccode = btn.data("product_seccode");
        copyProductInfo(product_seccode)
    }
    )

    $('[data-product="edit_product"]').off()
    $('[data-product="edit_product"]').on("click", function () {
        var btn = $(this)
        var product_seccode = btn.data("product_seccode");
        editProductInfo(product_seccode)
    }
    )

    $('[data-product="remove_product"]').off()
    $('[data-product="remove_product"]').on("click", function () {
        var product_seccode = $(this).data("product_seccode");
        var btn = $(this);
        var removePrd = confirm("Bu Ürünü Gerçekten Sistemden Kaldırmak İstiyormusunuz?")
        if (removePrd) {
            removeProduct(product_seccode, btn)
        } else {
            toastr["success"]("Tebrikler Bu Ürünü Silmeyin :))")
        }
    }
    )

    $('[data-product="ofline_product"]').off()
    $('[data-product="ofline_product"]').on("click", function () {
        var product_seccode = $(this).data("product_seccode");
        var btn = $(this);
        var place = $this.data("place")
        ofline_product(product_seccode, btn, place)
    }
    )

    $('[data-product="online_product"]').off()
    $('[data-product="online_product"]').on("click", function () {
        var product_seccode = $(this).data("product_seccode");
        var btn = $(this);
        var place = $this.data("place")
        online_product(product_seccode, btn, place)
    }
    )
    $('[data-product="show_page"]').on("change", function () {
        var $this = $(this)
        page_selected($this)
    });
    $('[data-product="show_result"]').on("change", function () {
        var $this = $(this)
        show_count($this)
    });
    $('[data-product="page_number"]').on("click", "button", function () {
        var $this = $(this)
        page_number($this)
    })

    $(".checkboxes").on("change", function () {
        var $this = $(this)
        checked($this)
    })
    $('[data-table="allchecked"]').on("change", function () {
        var $this = $(this)
        allchecked($this)
    })
    $("#allSelected").off()
    $("#allSelected").on("click", function () {
        var $this = $(this)
        allProductSelected($this)
    })

    $('[data-product="main_product"]').off();
    $('[data-product="main_product"]').on("click", function () {
        var $this = $(this)
        var product_seccode = $this.data("product_seccode")
        var place = $this.data("place")
        add_main_poruduct_list(product_seccode, $this, place)
    })



    function add_main_poruduct_list(product_seccode, btn, place) {
        var scriptURL = "/xhr/sendproduct/addmainprodcutlist";

        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "product_seccode": product_seccode,
            },
            dataType: "json",
            beforeSend: function () {
                //<div class="row"><div class="col-sm-12"><div class="progress"><div class="progress-bar-indeterminate"></div></div></div></div>
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim
                    if (typeof btn !== "undefined") {
                        if (data.favorite_statu == "add_main_product") {
                            if (place == "li") {
                                btn.html('<i class = "fa fa-star"></i> Ürünü Öne Çıkarma')
                            } else {
                                btn.html('<i class = "fa fa-star"></i>')
                            }

                        } else if (data.favorite_statu == "remove_main_product") {
                            if (place == "li") {
                                btn.html('<i class = "fa fa-star-o"></i> Ürünü Öne Çıkar ')
                            } else {
                                btn.html('<i class = "fa fa-star-o"></i>')
                            }

                        } else {

                            btn.parents("tr").remove()
                        }
                    } else {

                    }
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    function checked($this) {
        let allProductButton = $('[name="product_selected_type"]');
        var no_selected = true;
        if ($this.prop("checked")) {
            $("#allSelected").fadeIn()
        } else {

            $this.parents("table").find(".checkboxes").each(function () {
                if ($(this).prop("checked")) {
                    no_selected = false;
                }
            })
            if (no_selected) {
                $("#allSelected").fadeOut()
            }
        }
        allProductButton.val("table_selected")

    }

    function allchecked($this) {
        let allProductButton = $('[name="product_selected_type"]');
        if ($this.prop("checked")) {
            $this.parents("table").find(".checkboxes").each(function () {
                $(this).prop("checked", true)
            })
            $("#allSelected").fadeIn()
            $("#allSelected").html(" Tümünü Seç ")
        } else {
            $this.parents("table").find(".checkboxes").each(function () {
                $(this).prop("checked", false)
            })
            $("#allSelected").fadeOut()

        }
        allProductButton.val("table_selected")
    }
    function allProductSelected($this) {
        $("#product_table").find(".checkboxes").each(function () {
            $(this).prop("checked", false)
        })

        let allProductButton = $('[name="product_selected_type"]');
        if (allProductButton.val() == "allProductSelected") {
            allProductButton.val("table_selected")
            $this.html(" Tümünü Seç ")
            //$this.fadeOut()
        } else {
            allProductButton.val("allProductSelected")
            $this.html(" Tablodan Seç ")
        }

    }

    function get_pageno() {
        let page_no;
        $('[data-product="page_number"]').find("button").each(function () {
            if ($(this).hasClass("blue")) {
                page_no = $(this).data("page")
            }
        })
        return parseInt(page_no);
    }
    function show_count($this) {

        settings.html = true

        var value = $this.val();
        var page_no = get_pageno();
        settings.show = parseInt((value === "---" ? 10 : value))
        settings.start = (page_no - 1) * settings.show
        settings.end = settings.start + settings.show;

        addTable();
    }

    function page_selected($this) {

        settings.html = true
        let show_count = $('[data-product="show_result"]');
        var page_no = $this.val();

        settings.show = parseInt((show_count.val() === "---" ? 10 : show_count.val()))
        settings.start = (page_no - 1) * settings.show
        settings.end = settings.start + settings.show;
        addTable();
    }

    function page_number($this) {
        let show_count = $('[data-product="show_result"]');
        settings.html = true
        $('[data-product="page_number"]').find("button").each(function () {
            if ($(this).hasClass("blue")) {
                $(this).removeClass("blue")
            }
        })
        $this.addClass("blue")
        settings.show = parseInt(show_count.val() === "---" ? 10 : show_count.val())
        settings.start = (get_pageno() - 1) * settings.show
        settings.end = parseInt(settings.start) + settings.show;
        addTable();
    }

    function ofline_product(product_seccode, btn) {
        var scriptURL = "/xhr/sendproduct/oflineproduct";
        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "product_seccode": product_seccode,
            },
            dataType: "json",
            beforeSend: function () {
                //<div class="row"><div class="col-sm-12"><div class="progress"><div class="progress-bar-indeterminate"></div></div></div></div>
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim
                    if (typeof btn !== "undefined") {
                        btn.text("Yayına Al")
                        btn.children("i").addClass("fa-play")
                        btn.children("i").removeClass("fa-pause")

                        btn.attr("data-product", "online_product")

                        var spn = btn.parents("tr").find('[data-tdvarible="product_public"]').children("span")
                        if (spn.hasClass("label-success"))
                        {
                            spn.removeClass("label-success")
                            spn.addClass("label-danger")
                            spn.children("span").removeClass("fa-play")
                            spn.children("span").addClass("fa-pause")
                        }
                        $('[data-product="online_product"]').off()
                        $('[data-product="online_product"]').on("click", function () {
                            var product_seccode = $(this).data("product_seccode");
                            var btn = $(this);
                            online_product(product_seccode, btn)
                        }
                        )
                        $('[data-product="public"]').on("click", function () {
                            var product_seccode = $(this).data("product_seccode");
                            var btn = $(this);
                            var place = $this.data("place");
                            product_public(product_seccode, btn, place)
                        })
                    }

                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    function online_product(product_seccode, btn, place) {
        var scriptURL = "/xhr/sendproduct/onlineproduct";
        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "product_seccode": product_seccode,
            },
            dataType: "json",
            beforeSend: function () {
                //<div class="row"><div class="col-sm-12"><div class="progress"><div class="progress-bar-indeterminate"></div></div></div></div>
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim
                    btn.text("Yayından Kaldır")
                    btn.children("i").removeClass("fa-play")
                    btn.children("i").addClass("fa-pause")


                    var spn = btn.parents("tr").find('td[data-tdvarible="product_public"]').children("span")
                    if (spn.hasClass("label-danger"))
                    {
                        spn.removeClass("label-danger")
                        spn.addClass("label-success")
                        spn.children("span").removeClass("fa-pause")
                        spn.children("span").addClass("fa-play")
                    }
                    btn.attr("data-product", "ofline_product")
                    $('[data-product="ofline_product"]').off()
                    $('[data-product="ofline_product"]').on("click", function () {
                        var product_seccode = $(this).data("product_seccode");
                        var btn = $(this);
                        ofline_product(product_seccode, btn)
                    }
                    )

                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    //data-product="public"

    $('[data-product="public"]').on("click", function () {
        var product_seccode = $(this).data("product_seccode");
        var btn = $(this);
        var place = $(this).data("place");
        product_public(product_seccode, btn, place)
    })
    function product_public(product_seccode, btn, place) {

        var scriptURL = "/xhr/sendproduct/productpublic";
        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "product_seccode": product_seccode,
            },
            dataType: "json",
            beforeSend: function () {
                //<div class="row"><div class="col-sm-12"><div class="progress"><div class="progress-bar-indeterminate"></div></div></div></div>
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim
                    if (typeof btn !== "undefined") {
                        if (data.favorite_statu == "public") {
                            if (place == "li") {
                                btn.html('<i class = "fa fa-play"></i>Ürünü Yayından al')
                            } else {
                                btn.html('<i class = "fa fa-play"></i>')
                            }

                        } else if (data.favorite_statu == "nopublic") {
                            if (place == "li") {
                                btn.html('<i class = "fa fa-pause"></i>Ürünü Yayınla')
                            } else {
                                btn.html('<i class = "fa fa-pause"></i>')
                            }
                        }


                    }

                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }

    function removeProduct(product_seccode, btn) {

        var scriptURL = "/xhr/sendproduct/removeproduct";
        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "product_seccode": product_seccode,
            },
            dataType: "json",
            beforeSend: function () {
                //<div class="row"><div class="col-sm-12"><div class="progress"><div class="progress-bar-indeterminate"></div></div></div></div>
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim
                    if (typeof btn !== "undefined") {
                        btn.parents("tr").fadeOut("500", function () {
                            $(this).remove()
                        })
                    } else {
                        $this.find('input#' + product_seccode).parents("tr").remove()
                    }
                } else {
                    toastr["error"](data.msg)
                }
            }
        });


    }

    function copyProductInfo(product_seccode) {
        var scriptURL = "/xhr/sendproduct/getproductinfo";
        var form = $('[data-product="product-processing"]');
        $.ajax({type: "post",
            url: scriptURL,
            data: {"product_seccode": product_seccode},
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    resetProduction(form, data)
                    //Reset
                    form.attr("action", "/xhr/sendproduct/newproduct");
                    form.find('[name="product_name"]').val(capitalizeFirstLetter(data.product_name + '-kopya'))
                    form.find('[name="product_sub_name"]').val(capitalizeFirstLetter(data.product_sub_name))
                    form.find('[name="product_code"]').val(capitalizeFirstLetter(data.info.product_code))
                    var c = 0;
                    var category_list = data.info.product_category.split(",");
                    for (c = 0; c < category_list.length; c++) {
                        form.find('[data-category="select_special_fields"]').each(function () {
                            var inputval = $(this).val();
                            var selectval = category_list[c];
                            if (inputval == selectval) {
                                $(this).prop("checked", true);
                            }
                        })
                    }
                    form.find('[data-category="special_fields_section"]').html(data.special_fields)
                    $('[data-category="special_fields_section"]').on("change", "select", function () {
                        var selected_value = "";
                        $('[data-category="special_fields_section"]').find("select").each(function () {
                            if ($(this).val() !== "---") {
                                selected_value += '<input type="hidden" name="selected_special_fileds[]" value="' + $(this).val() + '" />'
                            }

                        })
                        $('[data-category="selected_special_fields_section"]').html(selected_value);
                    })
                    var f;
                    var sfieldstval
                    for (f = 0; f < data.special_fields_id_list.length; f++) {
                        sfieldstval = data.special_fields_id_list[f].value_id;
                        form.find('[data-category="selected_special_fields_section"]').append('<input type="hidden" name="selected_special_fileds[]" value="' + sfieldstval + '">');
                    }
                    form.find('[name="product_cost"]').val(data.info.product_cost)
                    form.find('[name="product_cost_unit"]').val(data.info.product_cost_unit).change()
                    form.find('[name="product_price_type"]').each(function () {
                        if ($(this).val() == data.info.product_price_type) {
                            $(this).prop("checked", true).change();
                        }
                    })
                    var pp = 0;
                    var rand;
                    var priceInfo;
                    var activeRandom;
                    for (pp = 0; pp < data.product_price_info.length; pp++) {
                        rand = Math.floor(Math.random() * 1000) + 1
                        priceInfo = data.product_price_info[pp];
                        if (priceInfo["activePrice"] == 1) {
                            activeRandom = rand;
                            form.find('[name="activeCheckPrice"]').val(rand)
                        }
                        form.find('[data-product_options_fields="add"]').append(product_price_type_options_html(rand, priceInfo));
                    }
                    $('[data-product_options_fields="remove_db"]').on("click", function (e) {
                        e.preventDefault();
                        if ($(this).parents(".add_fields").find('[name="activePrice"]').prop("checked")) {
                            toastr["error"]("Aktif Fiyat Seçeneğini Silemezsiniz.")
                        } else {
                            var product_price_option_seccode = $(this).data("product_price_option_seccode");
                            if (typeof product_price_option_seccode === "undefined") {
                                $(this).parents(".add_fields").fadeOut("500", function () {
                                    $(this).remove();
                                })
                            } else {
                                var scriptURL = "/xhr/sendproduct/removeproductpriceoption";
                                var btn = $(this)
                                $.ajax({type: "post",
                                    url: scriptURL,
                                    data: {"product_price_option_seccode": product_price_option_seccode},
                                    dataType: "json",
                                    beforeSend: function () {
                                        $("body").find(".waiting_screen").fadeIn()
                                    },
                                    success: function (data) {
                                        $("body").find(".waiting_screen").fadeOut()
                                        if (data.sonuc) {
                                            toastr["success"](data.msg)
                                            //Plugin haline getirelim
                                            btn.parents(".add_fields").fadeOut("500", function () {
                                                $(this).remove();
                                            })

                                        } else {
                                            toastr["error"](data.msg)
                                        }
                                    }
                                });
                            }
                        }

                    })

                    form.find('[name="activePrice"]').on("change", function () {
                        var activePriceRand = $(this).parents(".add_fields").find('[name="price_type_random[]"]').val();
                        form.find('[name="activeCheckPrice"]').val(activePriceRand)
                    })
                    var y = 0;
                    var paymentInfo;
                    for (y = 0; y < data.product_payment_info.length; y++) {
                        rand = Math.floor(Math.random() * 1000) + 1
                        paymentInfo = data.product_payment_info[y];
                        //console.log(priceInfo);
                        $('[name="payment_method[]"]').each(function () {
                            $(this).prepend('<input type="hidden" data-product="payment_method" name="product_payment_method_seccode[' + paymentInfo["payment_method"] + ']" value="' + paymentInfo["product_payment_method_seccode"] + '" />')
                            var $thisval = $(this).val();
                            if ($thisval == paymentInfo["payment_method"]) {
                                $(this).prop("checked", true)
                            }
                        })
                        form.find('[name="product_extra_price[' + paymentInfo["payment_method"] + ']"]').val(paymentInfo["payment_method_extra_price"])
                        form.find('[name="product_extra_price[' + paymentInfo["payment_method"] + ']"]').val(paymentInfo["payment_method_extra_price"]).prop("disabled", false)
                        form.find('[name="product_extra_price_unit[' + paymentInfo["payment_method"] + ']"]').val(paymentInfo["extra_price_unit"]).change();
                        form.find('[name="product_extra_price_unit[' + paymentInfo["payment_method"] + ']"]').val(paymentInfo["extra_price_unit"]).prop("disabled", false)
                    }

                    if (data.info.product_price_type == "flat") {
                        form.find('[name="product_flat_price"]').val(data.info.product_price)
                        form.find('[name="product_flat_price_unit"]').val(data.info.product_price_unit).change()
                    }

                    form.find('[name="product_discount_type"]').val(data.info.product_discount_type).change()
                    form.find('[name="product_discount_price"]').val(data.info.product_discount_price)
                    var product_tax_zone;
                    if (data.info.product_tax_zone == 1) {
                        product_tax_zone = true
                    } else {
                        product_tax_zone = false
                    }
                    form.find('[name="product_tax_zone"]').val(data.info.product_tax_zone).change()

                    form.find('[name="product_intax"]').prop("checked", data.info.product_intax)
                    form.find('[name="product_transport_type"]').each(function () {
                        if ($(this).val() == data.info.product_transport_type) {
                            $(this).prop("checked", true)
                        }
                    })
                    
                    form.find('[name="product_transport_price"]').val(data.info.product_transport_price)
                    form.find('[name="product_transport_price_unit"]').val(data.info.product_transport_price_unit).change()
                    var product_intransport;
                    if (data.info.product_intransport == 1) {
                        product_intransport = true
                    } else {
                        product_intransport = false
                    }
                    form.find('[name="product_intransport"]').prop("checked", product_intransport)
                    form.find('[name="product_delivey_time"]').val(data.info.product_delivey_time).change()
                    if (data.info.product_nostock == 1)
                        form.find('[name="product_nostock"]').prop("checked", true);
                    form.find('[name="product_stock"]').val(data.info.product_stock)
                    form.find(".md-checkbox-list input").each(function () {
                        if ($(this).val() == data.info.payment_method) {
                            $(this).prop("checked", true)
                        } else {
                            $(this).prop("checked", true)
                        }
                    })
                    if (data.info.product_type == "poster") {
                        form.find('[name="product_type"]').prop("checked", true)
                    } else if (data.info.product_type == "standart") {
                        form.find('[name="product_type"]').prop("checked", false)
                    }
                    form.find('[name="product_description"]').summernote('code', data.description);
                    form.find('[name="product_keywords"]').tagsinput('add', data.keywords);
                    toastr["success"](data.msg)
                } else {

                    toastr["error"](data.msg)
                }
            }
        });
    }

    function resetProduction(form, data) {
        form.find('[name="product_seccode"]').remove()
        form.find("#product_gallery_listing").html("")
        form.find("#product_gallery_image_line").html("")
        form.find("#product_gallery_first_image").html("")

        form.find('[name="product_name"]').val("")
        form.find('[name="product_sub_name"]').val("")
        form.find('[name="product_code"]').val("")

        form.find('[data-category="select_special_fields"]').each(function () {
            $(this).prop("checked", false);
        })
        form.find('[data-category="special_fields_section"]').html("")
        form.find('[data-category="selected_special_fields_section"]').html("")
        form.find('[name="product_cost"]').val(0)
        form.find('[name="product_cost_unit"]').val("---").change()
        //form.find('[name="product_price_type"]').val("flat").change()
        form.find('[name="product_price"]').val(0)
        form.find('[name="product_price_unit"]').val("---").change()

        form.find('[name="product_flat_price"]').val(0)
        form.find('[name="product_flat_price_unit"]').val("---").change()


        var rand = Math.floor(Math.random() * 1000) + 1
        var htmlblock = product_price_type_options_html(rand);
        if (data.info.product_price_type == "flat") {
            form.find('[data-product_options_fields="add"]').html(htmlblock)
        } else {
            form.find('[data-product_options_fields="add"]').html("")
        }

        form.find('[name="product_discount_price"]').val(0)
        form.find('[name="product_discount_type"]').val("---").change()
        form.find('[name="product_intransport"]').prop("checked", false);
        form.find('[name="product_transport_price"]').val(0)
        form.find('[name="product_transport_price_unit"]').val("---").change()


        form.find('[name="payment_method[]"]').prop("checked", false);
        form.find('[name="payment_method[]"]:first').prop("checked", true);

        form.find('[name="product_extra_price[credicart]"]').val(0)
        form.find('[name="product_extra_price_unit[credicart]"]').val("---").change()

        form.find('[name="product_extra_price[atthedoor]"]').val(0)
        form.find('[name="product_extra_price[atthedoor]"]').prop("disabled", true)
        form.find('[name="product_extra_price_unit[atthedoor]"]').val("---").change()

        form.find('[name="product_extra_price[inplace]"]').val(0)
        form.find('[name="product_extra_price[inplace]"]').prop("disabled", true)
        form.find('[name="product_extra_price_unit[inplace]"]').val("---").change()

        form.find('[name="product_extra_price[bank]"]').val(0)
        form.find('[name="product_extra_price[bank]"]').prop("disabled", true)
        form.find('[name="product_extra_price_unit[bank]"]').val("---").change()



        form.find('[name="product_delivey_time"]').val("---").change()
        form.find("#product_total_price").html("")
        form.find('[name="product_stock"]').val(0)
        form.find('[name="product_nostock"]').prop("checked", false);
        form.find('[name="product_description"]').summernote("reset")
        form.find('[name="product_keywords"]').tagsinput('removeAll');
    }

    function editProductInfo(product_seccode) {
        var scriptURL = "/xhr/sendproduct/getproductinfo";
        var form = $('[data-product="product-processing"]');
        $.ajax({type: "post",
            url: scriptURL,
            data: {"product_seccode": product_seccode},
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {

                    resetProduction(form, data)
                    //Reset

                    form.attr("action", "/xhr/sendproduct/editproduct");
                    $('[data-form="image_form"]').prepend('<input type="hidden" name="product_seccode" value="' + product_seccode + '" />');
                    form.prepend('<input type="hidden" name="product_seccode" value="' + product_seccode + '" />');
                    if (typeof data.product_gallery !== "undefined") {
                        var image_count = data.product_gallery.length;
                        var images_info = data.product_gallery;
                        var img_souce;
                        var image_line = "";
                        var first_image;
                        var border = "";
                        var i = 0;
                        var content = '<ul class="sortable">';
                        for (i = 0; i < image_count; i++) {
                            if (images_info[i].first_image == 1) {
                                border = 'style="border-color: rgb(236, 159, 24);"';
                            } else {
                                border = "";
                            }
                            //image/category_gallery_form/EXC5c6c62bcf1751/201902192310361978022014_ORJ.jpg';
                            img_souce = '/assets/tema/ks/image/product_gallery_form/' + images_info[i].image_uniqid + '/' + images_info[i].first_image_name + '_250.' + images_info[i].extention
                            content += '<li><div class="row"><div class="col-sm-8 product_image_content"><input type="hidden" name="product_gallery_seccode[]" value="' + images_info[i].product_gallery_seccode + '" /><input type="hidden" name="product_gallery_image[]" value="' + images_info[i].gallery_seccode + '" /><img ' + border + ' class="img-responsive img-thumbnail" src="' + img_souce + '" alt=""/><button class="btn btn-danger btn-remove-image" data-product="remove_product_gallery" data-product_gallery_seccode="' + images_info[i].product_gallery_seccode + '"><span class="fa fa-remove"></span></button></div></div></li>'

                            image_line += images_info[i].gallery_seccode + ","
                            if (images_info[i].first_image == 1) {
                                first_image = images_info[i].gallery_seccode;
                            }
                        }
                        form.find("#product_gallery_listing").html(content)

                        form.find("#product_gallery_image_line").html('<input type="hidden" name="image_line" value="' + image_line + '" />')
                        form.find("#product_gallery_first_image").html('<input type="hidden" name="first_image" value="' + first_image + '" />');
                        $('[data-product="remove_product_gallery"]').on("click", function (e) {
                            e.preventDefault();
                            var product_gallery_seccode = $(this).data("product_gallery_seccode")
                            var scriptURL = "/xhr/sendproduct/remove_product_image_from_product_gallery";
                            var btn = $(this)
                            $.ajax({type: "post",
                                url: scriptURL,
                                data: {"product_gallery_seccode": product_gallery_seccode},
                                dataType: "json",
                                beforeSend: function () {
                                    $("body").find(".waiting_screen").fadeIn()
                                },
                                success: function (data) {
                                    $("body").find(".waiting_screen").fadeOut()
                                    if (data.sonuc) {
                                        toastr["success"](data.msg)
                                        //Plugin haline getirelim
                                        btn.parent().parent().parent().fadeOut("500", function () {
                                            $(this).remove()
                                        })

                                    } else {
                                        toastr["error"](data.msg)
                                    }
                                }
                            });
                        })

                        //<div id="product_gallery_image_line"></div>
                        //<div id="product_gallery_first_image"></div>

                        $(".product_gallery").on("click", "img", function () {
                            $(this).parents("ul").find("img").each(function () {
                                $(this).css({
                                    "border-color": "#ddd",
                                })
                            })
                            $(this).css({
                                "border-color": "#ec9f18",
                            })
                            var firstimg;
                            firstimg = $(this).prev('input[name="product_gallery_image[]"]').val()
                            $("#product_gallery_first_image").html('<input type="hidden" name="first_image" value="' + firstimg + '" />');
                        })

                        $(".sortable").sortable({
                            opacity: 0.5,
                            delay: 250,
                            start: function (event, ui) {
                                $("#event_list").html("Başladı")
                            },
                            stop: function (event, ui) {
                                $("#event_list").html("Sonlandı")
                            },
                            sort: function (event, ui) {
                                $("#event_list").html("Sıralandı")
                            },
                            activate: function (event, ui) {
                                $("#event_list").html("activate")
                            },
                            update: function (event, ui) {
                                var image_line = 0;
                                var imgline = "";
                                var vla
                                $("ul.sortable li").each(function () {

                                    vla = $(this).find('input[name="product_gallery_image[]"]').val();
                                    if (typeof vla !== "undefined") {
                                        imgline += vla + ","
                                    }
                                })
                                $("#product_gallery_image_line").html('<input type="hidden" name="image_line" value="' + imgline + '" />')
                            }
                        });
                    }

                    form.find('[name="product_name"]').val(capitalizeFirstLetter(data.product_name))
                    form.find('[name="product_sub_name"]').val(capitalizeFirstLetter(data.product_sub_name))
                    form.find('[name="product_code"]').val(capitalizeFirstLetter(data.info.product_code))

                    var c = 0;
                    var category_list = data.info.product_category.split(",");
                    for (c = 0; c < category_list.length; c++) {
                        form.find('[data-category="select_special_fields"]').each(function () {
                            var inputval = $(this).val();
                            var selectval = category_list[c];
                            if (inputval == selectval) {

                                $(this).prop("checked", true);
                            }
                        })
                    }

                    form.find('[data-category="special_fields_section"]').html(data.special_fields)
                    $('[data-category="special_fields_section"]').on("change", "select", function () {
                        var selected_value = "";
                        $('[data-category="special_fields_section"]').find("select").each(function () {
                            if ($(this).val() !== "---") {
                                selected_value += '<input type="hidden" name="selected_special_fileds[]" value="' + $(this).val() + '" />'
                            }

                        })
                        $('[data-category="selected_special_fields_section"]').html(selected_value);
                    })
                    var f;
                    var sfieldstval
                    for (f = 0; f < data.special_fields_id_list.length; f++) {
                        sfieldstval = data.special_fields_id_list[f].value_id;
                        form.find('[data-category="selected_special_fields_section"]').append('<input type="hidden" name="selected_special_fileds[]" value="' + sfieldstval + '">');
                    }
                    //<div data-category="selected_special_fields_section"><input type="hidden" name="selected_special_fileds[]" value="48"></div>

                    form.find('[name="product_cost"]').val(data.info.product_cost)
                    form.find('[name="product_cost_unit"]').val(data.info.product_cost_unit).change()

                    form.find('[name="product_price_type"]').each(function () {
                        if ($(this).val() == data.info.product_price_type) {
                            $(this).prop("checked", true).change();
                        }
                    })

                    //form.find('[name="product_price_type"]').val(data.info.product_price_type).change()
                    var pp = 0;
                    var rand;

                    var priceInfo;
                    var activeRandom;
                    for (pp = 0; pp < data.product_price_info.length; pp++) {
                        rand = Math.floor(Math.random() * 1000) + 1
                        priceInfo = data.product_price_info[pp];

                        if (priceInfo["activePrice"] == 1) {
                            activeRandom = rand;
                            form.find('[name="activeCheckPrice"]').val(rand)
                        }
                        form.find('[data-product_options_fields="add"]').append(product_price_type_options_html(rand, priceInfo));
                    }


                    $('[data-product_options_fields="remove_db"]').on("click", function (e) {
                        e.preventDefault();

                        if ($(this).parents(".add_fields").find('[name="activePrice"]').prop("checked")) {
                            toastr["error"]("Aktif Fiyat Seçeneğini Silemezsiniz.")
                        } else {
                            var product_price_option_seccode = $(this).data("product_price_option_seccode");
                            if (typeof product_price_option_seccode === "undefined") {
                                $(this).parents(".add_fields").fadeOut("500", function () {
                                    $(this).remove();
                                })
                            } else {
                                var scriptURL = "/xhr/sendproduct/removeproductpriceoption";
                                var btn = $(this)
                                $.ajax({type: "post",
                                    url: scriptURL,
                                    data: {"product_price_option_seccode": product_price_option_seccode},
                                    dataType: "json",
                                    beforeSend: function () {
                                        $("body").find(".waiting_screen").fadeIn()
                                    },
                                    success: function (data) {
                                        $("body").find(".waiting_screen").fadeOut()
                                        if (data.sonuc) {
                                            toastr["success"](data.msg)
                                            //Plugin haline getirelim
                                            btn.parents(".add_fields").fadeOut("500", function () {
                                                $(this).remove();
                                            })

                                        } else {
                                            toastr["error"](data.msg)
                                        }
                                    }
                                });
                            }
                        }

                    })

                    form.find('[name="activePrice"]').on("change", function () {
                        var activePriceRand = $(this).parents(".add_fields").find('[name="price_type_random[]"]').val();
                        form.find('[name="activeCheckPrice"]').val(activePriceRand)
                    })





                    var y = 0;
                    var paymentInfo;
                    for (y = 0; y < data.product_payment_info.length; y++) {
                        rand = Math.floor(Math.random() * 1000) + 1
                        paymentInfo = data.product_payment_info[y];

                        $('[name="payment_method[]"]').each(function () {
                            $(this).prepend('<input type="hidden" name="product_payment_method_seccode[' + paymentInfo["payment_method"] + ']" value="' + paymentInfo["product_payment_method_seccode"] + '" />')
                            var $thisval = $(this).val();
                            if ($thisval == paymentInfo["payment_method"]) {
                                $(this).prop("checked", true)
                            }
                        })

                        //  form.find('[name="payment_method[]"]').val(paymentInfo["payment_method"]).prop("checked", true)
                        form.find('[name="product_extra_price[' + paymentInfo["payment_method"] + ']"]').val(paymentInfo["payment_method_extra_price"])
                        form.find('[name="product_extra_price[' + paymentInfo["payment_method"] + ']"]').val(paymentInfo["payment_method_extra_price"]).prop("disabled", false)
                        form.find('[name="product_extra_price_unit[' + paymentInfo["payment_method"] + ']"]').val(paymentInfo["extra_price_unit"]).change();
                        form.find('[name="product_extra_price_unit[' + paymentInfo["payment_method"] + ']"]').val(paymentInfo["extra_price_unit"]).prop("disabled", false)
                    }

                    if (data.info.product_price_type == "flat") {
                        form.find('[name="product_flat_price"]').val(data.info.product_price)
                        form.find('[name="product_flat_price_unit"]').val(data.info.product_price_unit).change()
                    }

                    form.find('[name="product_discount_type"]').val(data.info.product_discount_type).change()
                    form.find('[name="product_discount_price"]').val(data.info.product_discount_price)
                    var product_tax_zone;
                    if (data.info.product_tax_zone == 1) {
                        product_tax_zone = true
                    } else {
                        product_tax_zone = false
                    }
                    form.find('[name="product_tax_zone"]').val(data.info.product_tax_zone).change()

                    form.find('[name="product_intax"]').prop("checked", data.info.product_intax)
                    form.find('[name="product_transport_type"]').each(function () {
                        if ($(this).val() == data.info.product_transport_type) {
                            $(this).prop("checked", true)
                        }
                    })

                    form.find('[name="product_transport_price"]').val(data.info.product_transport_price)
                    form.find('[name="product_transport_price_unit"]').val(data.info.product_transport_price_unit).change()
                    var product_intransport;
                    if (data.info.product_intransport == 1) {
                        product_intransport = true
                    } else {
                        product_intransport = false
                    }
                    form.find('[name="product_intransport"]').prop("checked", product_intransport)
                    form.find('[name="product_delivey_time"]').val(data.info.product_delivey_time).change()
                    if (data.info.product_nostock == 1)
                        form.find('[name="product_nostock"]').prop("checked", true);
                    form.find('[name="product_stock"]').val(data.info.product_stock)
                    form.find(".md-checkbox-list input").each(function () {
                        if ($(this).val() == data.info.payment_method) {
                            $(this).prop("checked", true)
                        } else {
                            $(this).prop("checked", true)
                        }
                    })
                    if (data.info.product_type == "poster") {
                        form.find('[name="product_type"]').prop("checked", true)
                    } else if (data.info.product_type == "standart") {
                        form.find('[name="product_type"]').prop("checked", false)
                    }
                    form.find('[name="product_description"]').summernote('code', data.description);
                    form.find('[name="product_keywords"]').tagsinput('add', data.keywords);
                    toastr["success"](data.msg)
                } else {

                    toastr["error"](data.msg)
                }
            }
        });
    }
    function product_price_type_options_html(rand, priceInfo) {
        // console.log(priceInfo)
        var activePrice;
        if (typeof priceInfo !== "undefined") {
            if (priceInfo["activePrice"] == 1) {
                activePrice = "checked";
            } else {
                activePrice = "";
            }
            var tlSelected, dlSelected, euSelected
            if (priceInfo["product_price_unit"] == "tl") {
                tlSelected = "selected";
            } else if (priceInfo["product_price_unit"] == "dl") {
                dlSelected = "selected";
            } else if (priceInfo["product_price_unit"] == "eu") {
                euSelected = "selected";
            }


            //   console.log(priceInfo["activePrice"])
            var result;
            result = ' <div class="row add_fields">\n\
                                <input type="hidden" name="price_type_random[]" value="' + rand + '" />\n\
                                <input type="hidden" name="product_price_option_seccode[' + rand + ']" value="' + priceInfo["product_price_option_seccode"] + '" />\n\
                    <label class="col-md-3 control-label">Ürün Ücret</label>\n\
                    <div class="col-md-2"><input type="text" class="form-control" placeholder="Başlık" name="product_price_title[' + rand + ']" value="' + priceInfo["product_price_title"] + '"/></div>\n\
                    <div class="col-md-2"><input type="text" class="form-control" placeholder="Miktar" name="product_price[' + rand + ']" value="' + priceInfo["product_price"] + '"/></div>\n\
                    <div class="col-md-2">\n\
                        <select class="form-control" name="product_price_unit[' + rand + ']">\n\
                                            <option value="---">Birim Seçin </option>\n\
                                            <option value="tl" ' + tlSelected + '>TL</option>\n\
                                            <option  value="dl" ' + dlSelected + '>DOLAR</option>\n\
                                            <option  value="eu" ' + euSelected + '>EURO</option>\n\
                        </select>\n\
                    </div>\n\
                    <div class="col-sm-2"><div class="mt-radio-list"><label class="mt-radio"><input type="radio" name="activePrice" ' + activePrice + ' value="1"/> Aktif Fiyat<span></span></label></div></div>\n\
                    <div class="col-sm-1"><button class="btn btn-danger" data-product_options_fields="remove_db" data-product_price_option_seccode="' + priceInfo["product_price_option_seccode"] + '"><span class="fa fa-trash"></span></button></div>\n\
                    </div>'



            return result;


        } else {
            return ' <div class="row add_fields">\n\
                                <input type="hidden" name="price_type_random[]" value="' + rand + '" />\n\
                    <label class="col-md-3 control-label">Ürün Ücret</label>\n\
                    <div class="col-md-2"><input type="text" class="form-control" placeholder="Başlık" name="product_price_title[' + rand + ']" /></div>\n\
                    <div class="col-md-2"><input type="text" class="form-control" placeholder="Miktar" name="product_price[' + rand + ']"  /></div>\n\
                    <div class="col-md-2">\n\
                        <select class="form-control" name="product_price_unit[' + rand + ']">\n\
                                            <option value="---">Birim Seçin </option>\n\
                                            <option value="tl">TL</option>\n\
                                            <option  value="dl">DOLAR</option>\n\
                                            <option  value="eu">EURO</option>\n\
                        </select>\n\
                    </div>\n\
                    <div class="col-sm-2"><div class="mt-radio-list"><label class="mt-radio"><input type="radio" name="activePrice"  value="1"/> Aktif Fiyat<span></span></label></div></div>\n\
                    <div class="col-sm-1"><button class="btn btn-danger" data-product_options_fields="remove_fields"  ><span class="fa fa-trash"></span></button></div>\n\
                    </div>'
        }
    }
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    function product_filter(filter_type) {
        var scriptURL = "/xhr/sendproduct/product_filter";
        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "filter_type": filter_type,
            },
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim


                    var spn = btn.parents("tr").find('td[data-tdvarible="product_public"]').children("span")
                    if (spn.hasClass("label-danger"))
                    {
                        spn.removeClass("label-danger")
                        spn.addClass("label-success")
                        spn.children("span").removeClass("fa-pause")
                        spn.children("span").addClass("fa-play")
                    }
                    btn.attr("data-product", "ofline_product")
                    $('[data-product="ofline_product"]').off()


                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    return {
        addTable: function () {
            addTable()
            return $this; // Preserve the jQuery chainability 
        },
        removeProduct: function (product_seccode) {
            removeProduct(product_seccode)
            return $this; // Preserve the jQuery chainability 
        },
        pauseProduct: function (product_seccode) {
            ofline_product(product_seccode)
            return $this; // Preserve the jQuery chainability 
        },
        playProduct: function (product_seccode) {
            online_product(product_seccode)
            return $this; // Preserve the jQuery chainability 
        },
        product_filter: function (filter_type) {
            product_filter(filter_type)
            return $this; // Preserve the jQuery chainability 
        },
        remove_job_product_favorite_list: function (product_seccode) {
            add_main_poruduct_list(product_seccode)
            return $this;
        },
    }
}

