/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var page_category = function () {

    var category_tree = function () {
        $(".category_tree li").append('<span class="fa fa-arrow-down"></span><span class="fa fa-suitcase" data-toggle="modal" href="#move_category" data-category="move_category" ></span><span id="link_category" class="fa fa-link"></span>')
        $('[data-category="move_category"]').on("click", function () {
            var category_seccode = $(this).parents("li").data("category_seccode");
            var category_name = $(this).parents("li").children("a").data("category_name");
            console.log(category_name)
            //  alert(category_name)
            $("#move_category").find('[name="selected_category_seccode"]').val(category_seccode);
            $("#move_category").find(".selected_category_name").html('<strong>' + category_name + '</strong> kategorisini taşımak üzeresiniz.');
        })
        $(".category_tree li span#link_category").on("click", function (e) {
            e.preventDefault()
            var $this = $(this);
            var send_url = $this.parents("li").children("a").attr("href")
            window.location = send_url;
        })

        $(".category_tree li span.fa-arrow-down").on("click", function (e) {
            e.preventDefault()
            var $this = $(this)
            var li = $this.parents("li");
            $this.css({"transform": "rotate(180deg)"});
            li.next().slideToggle()
        })
    }
    var add_main_menu = function () {
        $('[data-category="add_main_menu"]').on("change", function () {
            var category_seccode = $(this).data("category_seccode");
            if ($(this).prop("checked")) {
                var scriptURL = "/xhr/productcategory/addmainmenu";
            } else {
                var scriptURL = "/xhr/productcategory/removemainmenu";
            }

            $.ajax({type: "post",
                url: scriptURL,
                async: true,
                cache: false,
                data: {"category_seccode": category_seccode},
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
        })
    }

    var add_image_main_slider = function () {
        $('[name="category_gallery_id"]').on("change", function () {
            console.log($(this))
            var category_gallery_id = $(this).data("category_gallery_id");
            if ($(this).prop("checked")) {
                var scriptURL = "/xhr/productcategory/addimagemainslider";
            } else {
                var scriptURL = "/xhr/productcategory/removeimagemainslider";
            }

            $.ajax({type: "post",
                url: scriptURL,
                async: true,
                cache: false,
                data: {"category_gallery_id": category_gallery_id},
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
        })
    }
    var sort_list = function () {
        $('.portlet-body tbody').sortable({
            opacity: 0.5,
            delay: 250,
            update: function (event, ui) {

                var category_seccode = [];
                $(this).children("tr").each(function () {
                    category_seccode.push($(this).find('input[name="category_seccode"]').val())

                })

                var scriptURL = "/xhr/productcategory/linecategory";
                $.ajax({type: "post",
                    url: scriptURL,
                    async: true,
                    cache: false,
                    data: {"category_seccode": category_seccode},
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
                console.log()
            }

        })
    }

    var handleremovecategory = function () {
        $('[data-category="remove_category"]').on("click", function () {
            var $this = $(this)
            var category_seccode = $this.data("category_seccode");
            var deleteCategory = confirm("Bu Kategoriyi ve Tüm Alt Kategorileri silemk istediğinizden eminmisiniz?");
            if (deleteCategory) {
                var scriptURL = "/xhr/productcategory/removecategory";
                $.ajax({type: "post",
                    url: scriptURL,
                    async: true,
                    cache: false,
                    data: {"category_seccode": category_seccode},
                    dataType: "json",
                    beforeSend: function () {
                        $("body").find(".waiting_screen").fadeIn()
                    },
                    success: function (data) {
                        $("body").find(".waiting_screen").fadeOut()
                        if (data.sonuc) {
                            $this.parents("tr").fadeOut("500", function () {
                                $this.remove()
                            })
                            toastr["success"](data.msg)

                        } else {
                            toastr["success"](data.msg)
                        }
                    }
                });
            } else {
                toastr["success"]("Tebrikler Kategorilere Kıymayın!!!")
            }


        })
    }

    var handleEditCategory = function () {
        $('[data-category="edit_category"]').on("click", function () {
            var $this = $(this)
            var category_seccode = $this.data("category_seccode");
            var scriptURL = "/xhr/productcategory/getcategory";
            $.ajax({type: "post",
                url: scriptURL,
                async: true,
                cache: false,
                data: {"category_seccode": category_seccode},
                dataType: "json",
                beforeSend: function () {
                    $("body").find(".waiting_screen").fadeIn()
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()
                    if (data.sonuc) {
                        //Reset
                        $("body").find('[name="category_name"]').val("")
                        $("body").find('[name="category_description"]').html("")
                        $("body").find('[name="category_parent"]').val("---").change();
                        $("body").find('[name="select_special_fileds"]').val("---").change();
                        $("body").find('[name="category_keywords"]').tagsinput('removeAll');
                        $("body").find('[name="special_fields"]').tagsinput('removeAll');
                        $("body").find(".bootstrap-tagsinput").find('input[name="selected_special_fields[]"]').each(function () {
                            $(this).remove()
                        })
                        $("body").find('[name="category_seccode"]').each(function () {
                            $(this).remove();
                        })

                        //Value
                        $("body").find('[name="category_name"]').val(ucwords(data.category_name))
                        $("body").find('[name="category_description"]').html(ucwords(data.info.category_description))
                        $("body").find('[name="category_parent"]').val(data.info.parent_category_id == "0" ? "---" : data.info.parent_category_id)
                        $("body").find('[name="category_keywords"]').tagsinput('add', data.keywords);
                        $("body").find('[data-form="xhr"]').prepend('<input type="hidden" name="category_seccode" value="' + data.info.category_seccode + '" />')

                        var fields = data.info.special_fileds.split(",");

                        var i = 0;
                        var fields_val;
                        var selected_fields_text;
                        for (i = 0; i < fields.length; i++) {
                            fields_val = fields[i];
                            if (fields_val !== "---") {
                                // console.log($("body").find('[name="select_special_fileds"]').children())
                                $("body").find('[name="select_special_fileds"]').children().each(function () {
                                    if ($(this).val() == fields_val) {
                                        selected_fields_text = $(this).text();
                                        $("body").find('[name="special_fields"]').tagsinput('add', selected_fields_text);
                                    }
                                })

                                $("body").find('[name="special_fields"]').next().append('<input type="hidden" value="' + fields_val + '" name="selected_special_fields[]" />')
                            }

                        }
                        $("body").find('[name="special_fields"]').on('beforeItemRemove', function (e) {
                            $('[data-category="select-special_fields"]').children().each(function () {
                                if ($(this).text() == e.item) {
                                    var deleteValue = $(this).val();
                                    $('[name="selected_special_fields[]"]').each(function () {
                                        if ($(this).val() == deleteValue) {
                                            $(this).remove();
                                        }
                                    })
                                }
                            })
                        });

                        $("body").find('[data-form="xhr"]').attr('action', "/xhr/productcategory/editcategory")
                        toastr["success"](data.msg)

                    } else {
                        toastr["success"](data.msg)
                    }
                }
            });


        })
    }
    var handleAddNewCategory = function () {
        $('[data-category="addNewCategory"]').on("click", function () {
            $("body").find('[name="category_name"]').val("")
            $("body").find('[name="category_description"]').html("")
            $("body").find('[name="category_parent"]').val("---")
            $("body").find('[name="category_keywords"]').tagsinput('removeAll');
            $("body").find('[data-form="xhr"]').find('[name="category_seccode"]').remove()
            $("body").find('[data-form="xhr"]').attr('action', "/xhr/productcategory/newcategory")
        })
    }
    var handleAddCategoryGallery = function () {
        $('[data-category="get_category_gallery"]').on("click", function () {
            var category_seccode = $(this).data("category_seccode")
            $('[data-form="image_form"]').find('[name="category_seccode"]').val(category_seccode)
            $("#category_gallery_table").category_table({
                "category_seccode": category_seccode
            })
        })
    }
    function ucwords(str) {
        //  discuss at: http://locutus.io/php/ucwords/
        // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
        // improved by: Waldo Malqui Silva (http://waldo.malqui.info)
        // improved by: Robin
        // improved by: Kevin van Zonneveld (http://kvz.io)
        // bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
        // bugfixed by: Cetvertacov Alexandr (https://github.com/cetver)
        //    input by: James (http://www.james-bell.co.uk/)
        //   example 1: ucwords('kevin van  zonneveld')
        //   returns 1: 'Kevin Van  Zonneveld'
        //   example 2: ucwords('HELLO WORLD')
        //   returns 2: 'HELLO WORLD'
        //   example 3: ucwords('у мэри был маленький ягненок и она его очень любила')
        //   returns 3: 'У Мэри Был Маленький Ягненок И Она Его Очень Любила'
        //   example 4: ucwords('τάχιστη αλώπηξ βαφής ψημένη γη, δρασκελίζει υπέρ νωθρού κυνός')
        //   returns 4: 'Τάχιστη Αλώπηξ Βαφής Ψημένη Γη, Δρασκελίζει Υπέρ Νωθρού Κυνός'

        return (str + '')
                .replace(/^(.)|\s+(.)/g, function ($1) {
                    return $1.toUpperCase()
                })
    }
    function ucwords(str) {
        //  discuss at: http://locutus.io/php/ucwords/
        // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
        // improved by: Waldo Malqui Silva (http://waldo.malqui.info)
        // improved by: Robin
        // improved by: Kevin van Zonneveld (http://kvz.io)
        // bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
        // bugfixed by: Cetvertacov Alexandr (https://github.com/cetver)
        //    input by: James (http://www.james-bell.co.uk/)
        //   example 1: ucwords('kevin van  zonneveld')
        //   returns 1: 'Kevin Van  Zonneveld'
        //   example 2: ucwords('HELLO WORLD')
        //   returns 2: 'HELLO WORLD'
        //   example 3: ucwords('у мэри был маленький ягненок и она его очень любила')
        //   returns 3: 'У Мэри Был Маленький Ягненок И Она Его Очень Любила'
        //   example 4: ucwords('τάχιστη αλώπηξ βαφής ψημένη γη, δρασκελίζει υπέρ νωθρού κυνός')
        //   returns 4: 'Τάχιστη Αλώπηξ Βαφής Ψημένη Γη, Δρασκελίζει Υπέρ Νωθρού Κυνός'

        return (str + '')
                .replace(/^(.)|\s+(.)/g, function ($1) {
                    return $1.toUpperCase()
                })
    }

    var refreshCategoryList = function () {
        $('[data-category="refresh_category_list"]').on("click", function (e) {
            e.preventDefault();
            var select = $('select[name="category_parent"]').parent();
            var scriptURL = "/xhr/productcategory/refreshCategoryList";
            $.ajax({type: "post",
                url: scriptURL,
                async: true,
                cache: false,
                data: {"style": "select"},
                dataType: "json",
                beforeSend: function () {
                    $("body").find(".waiting_screen").fadeIn()
                    select.html('<div class="row"><div class="col-sm-12"><div class="progress"><div class="progress-bar-indeterminate"></div></div></div></div>')
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()
                    if (data.sonuc) {
                        select.html(data.html);
                        toastr["success"](data.msg)

                    } else {
                        toastr["success"](data.msg)
                    }
                }
            });
        })
    }
    var handleSelectSpecialFields = function () {
        $('[data-category="select-special_fields"]').on("change", function () {
            var selected_value = $(this).children("option:selected").val();
            var selected_text = $(this).children("option:selected").text();
            var copy = false;
            if (selected_value !== "---") {
                $(this).parents("form").find('[name="selected_special_fields[]"]').each(function () {
                    if ($(this).val() == selected_value) {
                        copy = true;
                    }
                })
                if (!copy) {
                    $('[name="special_fields"]').tagsinput('add', selected_text);
                    $('[name="special_fields"]').next().append(' <input type="hidden" value="' + selected_value + '" name="selected_special_fields[]" />');
                    $('[name="special_fields"]').on('beforeItemRemove', function (e) {
                        $('[data-category="select-special_fields"]').children().each(function () {
                            if ($(this).text() == e.item) {
                                var deleteValue = $(this).val();
                                $('[name="selected_special_fields[]"]').each(function () {
                                    if ($(this).val() == deleteValue) {
                                        $(this).remove();
                                    }
                                })
                            }
                        })
                    });
                }
            }
        })
    }
    /*
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
     console.log(data);
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
     */
    var category_public = function () {
        $('[name="category_activated"]').on("change", function () {
            var category_seccode = $(this).data("category_seccode");
            var public;
            if ($(this).prop("checked")) {
                public = "true";
            } else {
                public = "false";
            }
            var scriptURL = "/xhr/productcategory/categorypublic";
            $.ajax({type: "post",
                url: scriptURL,
                async: true,
                cache: false,
                data: {"category_seccode": category_seccode, "public": public},
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
        })
    }
    return {
        init: function () {
            category_tree(); // handle adres Blok
            sort_list(); // handle adres Blok
            handleremovecategory();
            handleEditCategory();
            refreshCategoryList();
            handleAddNewCategory();
            handleAddCategoryGallery();
            handleSelectSpecialFields();
            add_main_menu();
            add_image_main_slider();
            //select_category();
            category_public();

        }
    }
}();


jQuery(document).ready(function () {
    page_category.init(); // init metronic core componets
});