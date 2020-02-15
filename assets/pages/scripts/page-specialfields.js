/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var page_specialfields = function () {



    var handleSpecialFields = function () {
        add_special_fields_value()
        remove_fields_value()
        remove_special_fields()
        $('[data-company="add_special_fields"]').on("click", function (e) {
            e.preventDefault();
            var random = Math.floor(Math.random() * 101);


            var special_fields_section = $('[data-company="special_fields_section"]')
            special_fields_section.append('<div data-company="special_fields">\n\
                                        <input type="hidden" name="fields_random[]" value="' + random + '" />\n\
                                    <div class="form-group caption m-heading-1 border-green m-bordered ">\n\
                                        <div class="row">\n\
                                            <div class="col-sm-11"></div>\n\
                                            <div class="col-sm-1"><span href="javascript:;" class="fa fa-close btn btn-circle btn-danger" data-company="remove_special_fields" ></span></div>\n\
                                        </div>\n\
                                        <div class="row">\n\
                                            <label class="col-md-3 control-label"></label>\n\
                                            <div class="col-md-4"><input type="text" class="form-control" value="" name="fields_name[' + random + ']" placeholder="Başlık Girin" maxlength="30" id="site_title"/><span class="help-block"> Bir Alan tanımlayın örn."MARKA". </span></div>\n\
                                            <div class="col-md-1">\n\
                                                <select class="form-control" name="fields_type[' + random + ']" >\n\
                                                    <option value="one">Tek Seçimli</option>\n\
                                                    <option value="multi">Çok Seçimli</option>\n\
                                                </select>\n\
                                            </div>\n\
                                        <div class="col-md-2"><a class="btn btn-info" href="javascript:;" data-company="add_special_fields_value">Değer Ekle</a></div>\n\
                                        </div>\n\
                                        <div data-company="special_fields_value_section" ></div>\n\
                                    </div>\n\
                                </div>');
            add_special_fields_value()
        })

    }

    function add_special_fields_value() {
        $('[data-company="add_special_fields_value"]').off()

        $('[data-company="add_special_fields_value"]').on("click", function (e) {
            e.preventDefault();
            var random_fields = $(this).parents('[data-company="special_fields"]').find('input[name="fields_random[]"]').val()

            var fields_value = $(this).parents('[data-company="special_fields"]').find('[data-company="special_fields_value_section"]')

            fields_value.append('<div data-company="special_fields_value" >\n\
                                            <div class="row" >\n\
                                                <label class="col-md-4 control-label"></label>\n\
                                                <div class="col-md-4"><input type="text" class="form-control" value="" name="fields_value[' + random_fields + '][]" placeholder="Başlık Girin" maxlength="30" id="site_title"/> <span class="help-block"> Bir Değer Ataması yapın örn."FREEDOM". </span></div>\n\
                                                <div class="col-md-2"><button class="btn red"  data-company="remove_fields_value">Kaldır</button></div>\n\
                                            </div>\n\
                                        </div>')

            remove_fields_value()
            remove_special_fields()




        })
    }

    function remove_fields_value() {
        $('[data-company="remove_fields_value"]').off()
        $('[data-company="remove_fields_value"]').on("click", function (e) {
            e.preventDefault();
            var fields_value_seccode = $(this).data("specialfields_value_seccode");
            var btn = $(this)
            if (typeof fields_value_seccode === "undefined") {
                btn.parents('[data-company="special_fields_value"]').fadeOut("500", function () {
                    $(this).remove()
                })
            } else {
                var scriptURL = "/xhr/specialfields/removefieldvalue";
                $.ajax({type: "post",
                    url: scriptURL,
                    data: {"fields_value_seccode": fields_value_seccode},
                    dataType: "json",
                    beforeSend: function () {
                        $("body").find(".waiting_screen").fadeIn()
                    },
                    success: function (data) {
                        $("body").find(".waiting_screen").fadeOut()
                        if (data.sonuc) {
                            toastr["success"](data.msg)
                            //Plugin haline getirelim
                            btn.parents('[data-company="special_fields_value"]').fadeOut("500", function () {
                                $(this).remove()
                            })

                        } else {
                            toastr["error"](data.msg)
                        }
                    }
                });
            }

        })
    }

    function remove_special_fields() {
        $('[data-company="remove_special_fields"]').off();
        $('[data-company="remove_special_fields"]').on("click", function (e) {
            e.preventDefault();
            var btn = $(this)
            var fields_seccode = $(this).data("fields_seccode");
            if (typeof fields_seccode === "undefined") {
                btn.parents('[data-company="special_fields"]').fadeOut("500", function () {
                    $(this).remove();

                })
            } else {
                var scriptURL = "/xhr/specialfields/removefield";
                $.ajax({type: "post",
                    url: scriptURL,
                    data: {"fields_seccode": fields_seccode},
                    dataType: "json",
                    beforeSend: function () {
                        $("body").find(".waiting_screen").fadeIn()
                    },
                    success: function (data) {
                        $("body").find(".waiting_screen").fadeOut()
                        if (data.sonuc) {
                            toastr["success"](data.msg)

                            btn.parents('[data-company="special_fields"]').fadeOut("500", function () {
                                $(this).remove();
                            })

                        } else {
                            toastr["error"](data.msg)
                        }
                    }
                });
            }

        })
    }
    return {
        init: function () {
            handleSpecialFields(); // handle adres Blok
        }
    }
}();


jQuery(document).ready(function () {
    page_specialfields.init(); // init metronic core componets
});