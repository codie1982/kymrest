/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var page_product = function () {
    function formatState(repo) {
        var text = repo.pname || repo.cname;
        var $state = $('<span>' + text + '</span>');
        return $state;
    }

    function formatRepoSelection(repo) {
        return repo.pname || repo.cname;
    }
    var product_stock_count = function () {
        $("#product_stock_count").TouchSpin({
            min: 0,
            max: 100,
            boostat: 10,
            verticalbuttons: false,
            verticalupclass: 'glyphicon glyphicon-plus',
            verticaldownclass: 'glyphicon glyphicon-minus'
        });
    }
    var select_category = function () {
        var placeholder = "Ürün|Ürün Kodu|Kategori|Kategori Anahtar Kelimesi";
        var $select = $('[data-select_filter="category"]')
        var scriptURL = "/xhr/sendproduct/searchProduct";
        $select.select2({
            placeholder: placeholder,
            width: null,
            language: "tr",
            ajax: {
                url: scriptURL,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var query = {
                        q: params.term,
                    }
                    return query;
                },
                processResults: function (data) {
                    //console.log(data);
                    return {
                        results: data.items
                    };
                }
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: formatState,
            templateSelection: formatRepoSelection,
        })

        $select.on("select2:unselect", function (e) {
            if ($select.val() == null) {
                var start_page,
                        _start_page,
                        show_count;
                $('[data-product="page_number"]').find("button").each(function () {
                    if ($(this).hasClass("blue")) {
                        start_page = $(this).data("page");
                    }
                })

                show_count = $('[data-product="show_result"]').children("option:selected").val()
                if (show_count == "---") {
                    show_count = 5
                }
                _start_page = (parseInt(start_page) - 1) * parseInt(show_count)
                var pTable = $("#product_table").product_table({
                    html: true,
                    start: parseInt(_start_page),
                    end: parseInt(_start_page) + parseInt(show_count),
                    show: parseInt(show_count),
                });
            } else {
                var start_page,
                        _start_page,
                        show_count;
                $('[data-product="page_number"]').find("button").each(function () {
                    if ($(this).hasClass("blue")) {
                        start_page = $(this).data("page");
                    }
                })

                show_count = $('[data-product="show_result"]').children("option:selected").val()
                if (show_count == "---") {
                    show_count = 5
                }
                _start_page = (parseInt(start_page) - 1) * parseInt(show_count)
                if (typeof e.params.data.cname !== "undefined") {

                    var pTable = $("#product_table").product_table({
                        html: true,
                        start: parseInt(_start_page),
                        end: parseInt(_start_page) + parseInt(show_count),
                        show: parseInt(show_count),
                        category: $select.val(),
                    });
                } else if (typeof e.params.data.pname !== "undefined") {
                    var pTable = $("#product_table").product_table({
                        html: true,
                        start: parseInt(_start_page),
                        end: parseInt(_start_page) + parseInt(show_count),
                        show: parseInt(show_count),
                        product: $select.val(),
                    });
                }
            }
        })
        $select.on("select2:select", function (e) {

            var start_page,
                    _start_page,
                    show_count;
            $('[data-product="page_number"]').find("button").each(function () {
                if ($(this).hasClass("blue")) {
                    start_page = $(this).data("page");
                }
            })

            show_count = $('[data-product="show_result"]').children("option:selected").val()
            if (show_count == "---") {
                show_count = 5
            }
            _start_page = (parseInt(start_page) - 1) * parseInt(show_count)
            if (typeof e.params.data.cname !== "undefined") {

                var pTable = $("#product_table").product_table({
                    html: true,
                    start: parseInt(_start_page),
                    end: parseInt(_start_page) + parseInt(show_count),
                    show: parseInt(show_count),
                    category: $select.val(),
                });
            } else if (typeof e.params.data.pname !== "undefined") {
                var pTable = $("#product_table").product_table({
                    html: true,
                    start: parseInt(_start_page),
                    end: parseInt(_start_page) + parseInt(show_count),
                    show: parseInt(show_count),
                    product: $select.val(),
                });
            }
        });
    }

    var product_sortable = function () {

    }

    var first_image = function () {

    }

    var calculate_price = function () {

        $('[name="product_flat_price"]').on("keyup", function () {
            calculateProductPrice()
        })

        $('[name="product_flat_price_unit"]').on("change", function () {
            calculateProductPrice()
        })
        $('[name="product_discount_type"]').on("change", function () {
            calculateProductPrice()
        })

        $('[name="product_discount_price"]').on("keyup", function () {
            calculateProductPrice()
        })

        $('[name="product_tax_zone"]').on("change", function () {
            calculateProductPrice()
        })
        $('[name="product_intax"]').on("change", function () {
            calculateProductPrice()
        })

        $('[name="product_transport_type"]').on("change", function () {
            calculateProductPrice()
        })
        $('[name="product_transport_price"]').on("keyup", function () {
            calculateProductPrice()
        })
        $('[name="product_intransport"]').on("change", function () {
            calculateProductPrice()
        })


        $('[name="activePrice"]').off()
        $('input[name="activePrice"]').on("change", function () {
            var active_random = $(this).parents(".add_fields").find('[name="price_type_random[]"]').val();
            $(this).parents('[data-product="price_type_section"]').find('[name="activeCheckPrice"]').val(active_random)
            calculateProductPrice();

        })
    }




    function calculateProductPrice() {
        var form = $('[data-product="product-processing"]')
        var product_price_type = form.find('[name="product_price_type"]:checked').val();
        var product_price;
        var product_price_unit;
        var activeCheckPriceRandom;

        if (product_price_type == "flat") {
            product_price = form.find('[name="product_flat_price"]').val()
            product_price_unit = form.find('[name="product_flat_price_unit"]').children("option:selected").val();
        } else if (product_price_type == "options") {
            activeCheckPriceRandom = form.find('[name="activeCheckPrice"]').val()
            //console.log(activeCheckPriceRandom);
            product_price = form.find('[name="product_price[' + activeCheckPriceRandom + ']"]').val()
            //console.log(product_price);
            product_price_unit = form.find('[name="product_price_unit[' + activeCheckPriceRandom + ']"]').children("option:selected").val();
            //console.log(product_price_unit);
        }


        if (product_price == "")
            product_price = 0;

        //console.log(product_price);

        var product_discount_type = form.find('[name="product_discount_type"]').children("option:selected").val();
        var product_discount_price = form.find('[name="product_discount_price"]').val();
        if (product_discount_price == "")
            product_discount_price = 0;
        var product_tax_zone = form.find('[name="product_tax_zone"]').children("option:selected").val();
        var product_intax = form.find('[name="product_intax"]').prop("checked") ? "1" : "0";
        var product_transport_price = form.find('[name="product_transport_price"]').val()
        if (product_transport_price == "")
            product_transport_price = 0;
        var product_transport_price_unit = form.find('[name="product_transport_price_unit"]').children("option:selected").val();
        var product_intransport = form.find('[name="product_intransport"]').prop("checked") ? "1" : "0";

        var scriptURL = "/xhr/sendproduct/calculateprice";
        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "product_price": product_price,
                "product_price_unit": product_price_unit,
                "product_discount_type": product_discount_type,
                "product_discount_price": product_discount_price,
                "product_tax_zone": product_tax_zone,
                "product_intax": product_intax,
                "product_transport_price": product_transport_price,
                "product_transport_price_unit": product_transport_price_unit,
                "product_intransport": product_intransport,
            },
            dataType: "json",
            beforeSend: function () {
                //<div class="row"><div class="col-sm-12"><div class="progress"><div class="progress-bar-indeterminate"></div></div></div></div>
                $("#product_total_price").html('<div class="row"><div class="col-sm-12"><div class="progress"><div class="progress-bar-indeterminate"></div></div></div></div>')
            },
            success: function (data) {

                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim
                    $("#product_total_price").html('<span class="bold" style="font-size:14px;">\n\
                    ' + data.price.cost_price + ' ' + data.price.unit + '</span>  <span class="label label-sm label-danger" > %' + data.price.discount_rate + ' İndirim</span>\n\
                     <span style="font-size:10px;"> ( ' + data.price.first_price + ' TL - %' + data.price.discount_rate + ' İndrim  + ' + data.price.tax_price + ' ' + data.price.unit + ' %' + data.price.tax_rate + ' KDV  + ' + data.price.transport_price + ' ' + data.price.unit + 'G)</span> ')
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }

    var edit_product = function () {
        var pTable = $("#product_table").product_table();
    }
    var new_production = function () {
        $('[data-production="newproduction"]').on("click", function () {
            var form = $('[data-product="product-processing"]');
            form.attr("action", "/xhr/sendproduct/newproduct");
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

            form.find('[data-product_options_fields="add"]').html("")
            form.find('[data-category="special_fields_section"]').html("")
            form.find('[data-category="selected_special_fields_section"]').html("")
            form.find('[name="product_cost"]').val(0)
            form.find('[name="product_cost_unit"]').val("---").change()
            form.find('[name="product_flat_price"]').val(0)
            form.find('[name="product_flat_price_unit"]').val("---").change()
            form.find('[name="product_price"]').val(0)
            form.find('[name="product_price_unit"]').val("---").change()
            form.find('[name="product_discount_price"]').val(0)
            form.find('[name="product_discount_type"]').val("---").change()
            form.find('[name="product_transport_price"]').val(0)
            form.find('[name="product_transport_price_unit"]').val("---").change()
            form.find("#product_total_price").html("")
            form.find('[name="product_stock"]').val(0)
            form.find('[name="product_description"]').summernote("reset")
            form.find('[name="product_keywords"]').tagsinput('removeAll');
        })
    }

    var category_special_fields = function () {
        $('[data-category="select_special_fields"]').on("change", function () {
            var selected_category_id = $(this).val();
            if ($(this).prop("checked")) {
                var isReady = "";
                if ($('[data-category="special_fields_section"]').find('[name="special_fields"]').length > 0) {
                    $('[data-category="special_fields_section"]').find('[name="special_fields"]').each(function () {
                        isReady += $(this).val() + ",";
                    })
                } else {
                    isReady = 0;
                }

                var scriptURL = "/xhr/sendproduct/getcategoryspecialfields";
                $.ajax({type: "post",
                    url: scriptURL,
                    data: {
                        "selected_category_id": selected_category_id,
                        "isReady": isReady,
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $("body").find(".waiting_screen").fadeIn()
                    },
                    success: function (data) {
                        $("body").find(".waiting_screen").fadeOut()
                        if (data.sonuc) {

                            $('[data-category="special_fields_section"]').append(data.html)
                            $('[data-category="special_fields_section"]').on("change", "select", function () {
                                var selected_value = "";
                                $('[data-category="special_fields_section"]').find("select").each(function () {
                                    if ($(this).val() !== "---") {
                                        selected_value += '<input type="hidden" name="selected_special_fileds[]" value="' + $(this).val() + '" />'
                                    }

                                })
                                $('[data-category="selected_special_fields_section"]').html(selected_value);
                            })
                            toastr["success"](data.msg)
                        } else {
                            toastr["error"](data.msg)
                        }
                    }
                });
            } else {

                if ($('[data-category="special_fields_section"]').find('[name="selected_category[]"]').length > 0) {

                    $('[data-category="special_fields_section"]').find('[name="selected_category[]"]').each(function () {
                        //console.log(selected_category_id + " " + $(this).val())
                        if ($(this).val() == selected_category_id) {
                            $(this).parent().parent().parent().remove()
                        }
                    })
                } else {
                    isReady = 0;
                }
            }

        })
    }
    var selected_special_fields = function () {}

    var refresh_table = function () {
        $('[data-refresh="product_table"]').on("click", function (e) {
            e.preventDefault();
            //let param = $(".table_parameter").text()
            let param = $('[name="table_settings"]').val()
            param === "" ? $("#product_table").product_table({"html": true}) : $("#product_table").product_table(JSON.parse(param))
        })
    }
    var remove_all = function () {
        $('[data-product="remove_all"]').on("click", function (e) {
            e.preventDefault();
            var product_seccode;
            var removeProduct = confirm("Bu Ürünü Gerçekten Sistemden Kaldırmak İstiyormusunuz?")
            if (removeProduct) {
                $("#product_table").find("table tr").each(function () {
                    var checkbox = $(this).children("td").find('input[type="checkbox"]')
                    //console.log(checkbox);
                    if (checkbox.prop("checked")) {
                        product_seccode = checkbox.data("product_seccode");
                        $("#product_table").product_table().removeProduct(product_seccode)
                    }
                })
            } else {
                toastr["success"]("Tebrikler Ürünleri Silmeyin :))")

            }

        })
    }
    var remove_all_pause = function () {
        $('[data-product="remove_all_pause"]').on("click", function (e) {
            e.preventDefault();
            var product_seccode;
            $("#product_table").find("table tr").each(function () {
                var checkbox = $(this).children("td").find('input[type="checkbox"]')
                //console.log(checkbox);
                if (checkbox.prop("checked")) {
                    product_seccode = checkbox.data("product_seccode");
                    $("#product_table").product_table().pauseProduct(product_seccode)

                }
            })
        })
    }

    var product_filter = function () {
        $('[data-product="remove_all_pause"]').on("click", function (e) {
            e.preventDefault();
        })

        $('[data-filter_toggle]').on("click", function () {
            var $this = $(this)
            var filter = $this.data("filter_toggle")
            $this.parents('[data-product="filter_section"]').find('[data-filter]').each(function () {
                $(this).hide()
            })
            $this.parents('[data-product="filter_section"]').find('[data-filter="' + filter + '"]').show()
        })
    }

    var prouct_price_type = function () {
        $('[name="product_price_type"]').on("change", function (e) {
            e.preventDefault();
            var check_value = $(this).val();
            $('[data-product="price_type_section"]').find('[data-product]').each(function () {
                $(this).hide();
            })

            $('[data-product="price_type_section"]').find('[data-product="' + check_value + '_price_section"]').show();

        })


        $('[data-product_options_fields="add_fields"]').on("click", function (e) {
            e.preventDefault();
            var rand = Math.floor(Math.random() * 1000) + 1
            var htmlblock = ' <div class="row add_fields">\n\
                                <input type="hidden" name="price_type_random[]" value="' + rand + '" />\n\
                    <label class="col-md-3 control-label">Ürün Ücret</label>\n\
                    <div class="col-md-2"><input type="text" class="form-control" placeholder="Başlık" name="product_price_title[' + rand + ']"/></div>\n\
                    <div class="col-md-2"><input type="text" class="form-control" placeholder="Miktar" name="product_price[' + rand + ']"/></div>\n\
                    <div class="col-md-2">\n\
                        <select class="form-control" name="product_price_unit[' + rand + ']">\n\
                                            <option value="---">Birim Seçin </option>\n\
                                            <option value="tl">TL</option>\n\
                                            <option  value="dl">DOLAR</option>\n\
                                            <option  value="eu">EURO</option>\n\
                        </select>\n\
                    </div>\n\
                    <div class="col-sm-2"><div class="mt-radio-list"><label class="mt-radio"><input type="radio" name="activePrice" value="1"/> Aktif Fiyat<span></span></label></div></div>\n\
                    <div class="col-sm-1"><button class="btn btn-danger" data-product_options_fields="remove_fields"><span class="fa fa-trash"></span></button></div>\n\
                    </div>';

            $(this).parents(['[data-product="options_price_section"]']).find('[data-product_options_fields="add"]').append(htmlblock);

            $('[name="product_price[' + rand + ']"]').on("keyup", function () {
                calculateProductPrice();
            })
            $('[name="product_price_unit[' + rand + ']"]').on("change", function () {
                calculateProductPrice();
            })
            $('[data-product_options_fields="remove_fields"]').on("click", function (e) {
                e.preventDefault();
                $(this).parents(".add_fields").fadeOut("500", function () {
                    $(this).remove();
                })
            })
            $('[name="activePrice"]').on("change", function () {
                var active_random = $(this).parents(".add_fields").find('[name="price_type_random[]"]').val();
                $(this).parents('[data-product="price_type_section"]').find('[name="activeCheckPrice"]').val(active_random)
                calculateProductPrice();

            })
        })

    }
    var prouct_payment_type = function () {
        $('[name="payment_method[]"]').on("change", function (e) {
            e.preventDefault();
            var $this = $(this);
            var check_value = $this.val();
            if ($this.prop("checked")) {
                $this.parents(".mt-checkbox-list").find('[name="product_extra_price[' + check_value + ']"]').attr("disabled", false);
                $this.parents(".mt-checkbox-list").find('[name="product_extra_price_unit[' + check_value + ']"]').attr("disabled", false);
            } else {
                $this.parents(".mt-checkbox-list").find('[name="product_extra_price[' + check_value + ']"]').attr("disabled", true);
                $this.parents(".mt-checkbox-list").find('[name="product_extra_price_unit[' + check_value + ']"]').attr("disabled", true);
            }
        })



    }

    var product_make_filter = function () {
        $('[data-item_table]').on("click", function (e) {
            e.preventDefault();
            let filter_type = $(this).data("item_table")
            $("#product_table").product_table({html: true, filter: filter_type});
        })
    }

    var favorite_products_list = function () {
        $('[data-product="favorite_product_list"]').on("click", function () {
            var scriptURL = "/xhr/sendproduct/getfavoriteproductlist";
            $.ajax({type: "post",
                url: scriptURL,
                data: {
                    "list": true,
                    "show": 30,
                    "start": 0,
                    "end": 16,
                },
                dataType: "json",
                beforeSend: function () {
                    $("body").find(".waiting_screen").fadeIn()
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()
                    if (data.sonuc) {
                        $("#favorite_product_table").html(data.table)
                        $("#favorite_product_table tbody").sortable({
                            opacity: 0.5,
                            delay: 250,
                            update: function (event, ui) {
                                var product_seccode = [];
                                $(this).children("tr").each(function () {
                                    product_seccode.push($(this).find('input[name="product_seccode"]').val())
                                })
                                console.log(product_seccode)

                                var scriptURL = "/xhr/sendproduct/sortfavoriteproductlist";
                                $.ajax({type: "post",
                                    url: scriptURL,
                                    async: true,
                                    cache: false,
                                    data: {"product_seccode": product_seccode},
                                    dataType: "json",
                                    beforeSend: function () {
                                        $("body").find(".waiting_screen").fadeIn()
                                    },
                                    success: function (data) {
                                        $("body").find(".waiting_screen").fadeOut()
                                        if (data.sonuc) {
                                            toastr["success"](data.msg)
                                        } else {
                                            toastr["success"](data.msg)
                                        }
                                    }
                                });
                                // console.log()
                            }

                        })
                        $('[data-product="remove_product_favorite_list"]').on("click", function () {
                            var product_seccode = $(this).data("product_seccode");
                            var btn = $(this)
                            $("#product_table").product_table().remove_job_product_favorite_list(product_seccode, btn)
                        })

                        toastr["success"](data.msg)
                    } else {
                        toastr["error"](data.msg)
                    }
                }
            });
        })

    }
    var remove_product_favorite_list = function () {

    }
    var favorite_products_list_sort = function () {

        $("#favorite_product_table tbody").sortable({
            opacity: 0.5,
            delay: 250,
            update: function (event, ui) {
                var category_seccode = [];
                $(this).children("tr").each(function () {
                    category_seccode.push($(this).find('input[name="product_seccode"]').val())
                })
            }

        })
    }

    var allSelectedButton = function () {

    }

    var collectiveUpdates = function () {
        $('[data-product="collective_update"]').on("click", function () {
            let collective_type = $(this).data("collective_type");
            let product_selected_type = $('[name="product_selected_type"]').val();
            let product_list = "";
            $("#" + collective_type).find(".product_select_type").html("")

            if (product_selected_type == "table_selected") {
                let checked = false;
                $("#product_table").find(".checkboxes").each(function () {
                    if ($(this).prop("checked")) {
                        checked = true;
                        //data-product_seccode="SRT5ccbef06dfbd6"
                        let product_seccode = $(this).data("product_seccode");
                        if (typeof product_seccode !== "undefined")
                            product_list += '<input type="hidden" name="product_list[]" value="' + product_seccode + '" />';
                    }
                })
                if (!checked) {
                    alert("Ürün Tablosundan bir veya birkaç ürün seçmeyi deneyin")
                    return false
                }
            } else if (product_selected_type == "allProductSelected") {
                let pl = $('[name="table_settings"]').val();
                let settings = JSON.parse(pl);

                product_list += '<input type="hidden" name="product[]" value="' + settings.product + '" />';
                product_list += '<input type="hidden" name="category[]" value="' + settings.category + '" />';
                product_list += '<input type="hidden" name="filter" value="' + settings.filter + '" />';
            }

            $("#" + collective_type).find(".product_select_type").html(product_list)
            $("#" + collective_type).find(".product_select_type").prepend('<input type="hidden" name="product_selected_type" value="' + product_selected_type + '" />')
        })
    }
    return {
        init: function () {
            select_category(); // handle adres Blok
            product_stock_count(); // handle adres Blok
            product_sortable(); // handle adres Blok
            first_image(); // handle adres Blok
            calculate_price(); // handle adres Blok
            edit_product(); // handle adres Blok
            new_production(); // handle adres Blok
            category_special_fields(); // handle adres Blok
            selected_special_fields(); // handle adres Blok
            refresh_table(); // handle adres Blok
            remove_all(); // handle adres Blok
            remove_all_pause(); // handle adres Blok
            product_filter(); // handle adres Blok
            prouct_price_type(); // handle adres Blok
            prouct_payment_type(); // handle adres Blok
            product_make_filter(); // handle adres Blok
            favorite_products_list(); // handle adres Blok
            favorite_products_list_sort(); // handle adres Blok
            remove_product_favorite_list(); // handle adres Blok
            allSelectedButton(); // handle adres Blok
            collectiveUpdates(); // handle adres Blok
        }
    }
}();
jQuery(document).ready(function () {
    page_product.init(); // init metronic core componets
});