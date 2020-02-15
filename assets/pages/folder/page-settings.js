/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var page_settings = function () {
    var handleBootstrapMaxlength = function () {
        $('#site_title').maxlength({
            limitReachedClass: "label label-danger",
        })
        $('#site_description').maxlength({
            limitReachedClass: "label label-danger",
        })
        $('#site_url').maxlength({
            limitReachedClass: "label label-danger",
        })
        $('#site_email').maxlength({
            limitReachedClass: "label label-danger",
        })
        $('#site_description').maxlength({
            limitReachedClass: "label label-danger",
        })
        $('#site_phone_number').maxlength({
            limitReachedClass: "label label-danger",
        })
        $('#company_name').maxlength({
            limitReachedClass: "label label-danger",
        })

    }

    var handleadres = function () {
        if ($(".adres_section").length != 0) {
            $('[data-company="adres_info"]').adres_html_block({
                "adres_type": "settings",
                html: false
            });
        }

    }
    var handletaxoffice = function () {
        if ($(".adres_section").length != 0) {
            $('[data-company="adres_info"]').tax_seciton_block({
                html: false
            });
        }

    }
    var handlebank = function () {
        if ($(".account_info").length != 0) {
            $('[data-company="account_info"]').company_account_html_block({
                html: false
            });
        }
        $('[data-select="add-new-account-section"]').on("click", function (e) {
            e.preventDefault()
            $('[data-company="account_info"]').company_account_html_block({
                html: true
            });
        })




    }
    var add_currency = function () {
        $('[data-settings="add_currency"]').on("click", function (e) {
            e.preventDefault();
            let selected_currency = $(this).parents("form").find('[name="product_currency"]').children("option:selected").val()
            let currency_html = "";
            if (selected_currency !== "---") {
                if (selected_currency !== "tl") {
                    let add_currency = true
                    $(this).parents("form").find('[data-currency]').each(function () {
                        let currency = $(this).data("currency");
                        if (currency == selected_currency) {
                            add_currency = false
                        }
                    })
                    if (add_currency) {
                        switch (selected_currency) {
                            case"dl":
                                currency_html += ' <div class="form-group" data-currency="dl">\n\
                                                    <div class="row">\n\
                                                            <label class="col-md-3 control-label">Dolar</label>\n\
                                                            <div class="col-md-4">\n\
                                                            <input type="text" class="form-control" placeholder="Döviz Kuru Ekleyin" data-settings="number_mask" name="product_currency_price[dl]"/>\n\
                                                            <p class="help-inline">Dolar için bir Döviz Kuru Belirleyin (.)</p>\n\
                                                            </div>\n\
                                                            <div class="col-sm-3"><button  class="btn btn-circle btn-info " disabled > Merkez Bankası ile Güncelle</button> </div>\n\
                                                            <div class="col-sm-1"><button  class="btn btn-circle btn-danger " data-currency="remove_currency" data-currency_mode="dl"  > Kaldır</button> </div>\n\
                                                    </div>\n\
                                                </div>';

                                break;
                            case"eu":
                                currency_html += ' <div class="form-group" data-currency="eu">\n\
                                                    <div class="row">\n\
                                                            <label class="col-md-3 control-label">Euro</label>\n\
                                                            <div class="col-md-4">\n\
                                                            <input type="text" class="form-control" placeholder="Döviz Kuru Ekleyin" data-settings="number_mask"  name="product_currency_price[eu]"/>\n\
                                                            <p class="help-inline">Euro için bir Döviz Kuru Belirleyin (.)</p>\n\
                                                            </div>\n\
                                                            <div class="col-sm-3"><button  class="btn btn-circle btn-info " disabled > Merkez Bankası ile Güncelle</button> </div>\n\
                                                            <div class="col-sm-1"><button  class="btn btn-circle btn-danger" data-currency="remove_currency" data-currency_mode="eu" > Kaldır</button> </div>\n\
                                                    </div>\n\
                                                </div>';
                                break;


                        }
                        $(this).parents("form").find('[data-settings="currency_section"]').append(currency_html);
                        //$(this).parents("form").find('[data-settings="number_mask"]').AutoNumeric();
                        //new AutoNumeric($(this).parents("form").find('[data-settings="number_mask"]'), {currencySymbol: ' TL ', currencySymbolPlacement: 's'})

                        $('[data-currency="remove_currency"]').off();
                        $('[data-currency="remove_currency"]').on("click", function (e) {
                            e.preventDefault();
                            let currency_mode = $(this).data("currency_mode")
                            $(this).parents('[data-currency="' + currency_mode + '"]').remove();
                            let currency_seccode = $(this).data("currency_seccode")
                            if (typeof currency_seccode !== "undefined") {
                                //db'den silme yapmamın gerekli

                            }
                        })
                    } else {
                        alert("Bu Döviz Birimi Daha Önce Eklenmiş Lütfen Başka bir Döviz Birimi Seçmeyi Deneyin")
                    }
                } else {
                    alert("Lütfen Türk Lirasından Başka bir Döviz Birimi Seçiniz")
                }
            } else {
                alert("Lütfen Döviz Birimi Seçiniz")
            }
        })

    }
    var currency_remove = function () {
        $('[data-currency="remove_currency"]').on("click", function (e) {
            e.preventDefault();
            let currency_mode = $(this).data("currency_mode")
            let currency_seccode = $(this).data("currency_seccode")
            var button = $(this);
            if (typeof currency_seccode !== "undefined") {
                var scriptURL = "/xhr/settings/removecurrency";
                $.ajax({type: "post",
                    url: scriptURL,
                    data: {"currency_seccode": currency_seccode},
                    dataType: "json",
                    beforeSend: function () {
                        $("body").find(".waiting_screen").fadeIn()
                    },
                    success: function (data) {
                        $("body").find(".waiting_screen").fadeOut()
                        if (data.sonuc) {
                            toastr["success"](data.msg)
                            button.parents('[data-currency="' + currency_mode + '"]').remove();
                        } else {
                            toastr["error"](data.msg)
                        }
                    }
                });

            }



        })
    }

    var product_unit = function () {
        $('[name="product_no_unit"]').on("change", function () {
            if ($(this).prop("checked")) {
                $('[data-settings="unit_section"]').hide()
            } else {
                $('[data-settings="unit_section"]').show()
            }
        })
    }
    //name="extra_field_workable_type"
    var change_extra_field_workable_type = function () {
        $('[name="extra_field_workable_type"]').change(function () {
            if ($(this).val() == "changeable") {
                $('[data-settings="extra_price_section"]').find('[data-extra="extra_field_workable_type"]').each(function () {
                    $(this).attr("disabled", true)
                })
            } else if ($(this).val() == "constant") {
                $('[data-settings="extra_price_section"]').find('[data-extra="extra_field_workable_type"]').each(function () {
                    $(this).attr("disabled", false)
                })
            } else {

            }

        })
    }

    var add_product_extrprice = function () {
        $('[data-settings="add_extra_price"]').on("click", function (e) {
            e.preventDefault();
            let selected_extra_price = $(this).parents("form").find('[name="product_extra_price_list"]').children("option:selected").val()
            if (selected_extra_price !== "---") {
                let add_extra_price = true;
                let extra_price_html = "";

                $(this).parents("form").find('[data-extra_price]').each(function () {
                    let extra_price = $(this).data("extra_price")
                    console.log(extra_price + " " + selected_extra_price)
                    if (extra_price == selected_extra_price) {
                        add_extra_price = false;
                    }
                });
                if (add_extra_price) {
                    switch (selected_extra_price) {
                        case"credicart":
                            extra_price_html += ' <div class="form-group card" data-extra_price="credicart">\n\
                                                        <div class="row">\n\
                                                        <label class="col-md-2 control-label">Kredi Kartı</label>\n\
                                                        <div class="col-md-2"><div class="mt-checkbox-list" style="margin-top: 8px;"><label class="mt-checkbox"><input type="hidden" value="1" name="credicart"/><input type="checkbox" id="checkbox29" class="md-check" value="1" name="credicart_extra_price"/>Extra Ücret Alanı Ekle<span></span></label></div></div>\n\
                                                        <div class="col-md-3"><div class="mt-checkbox-list" style="margin-top: 8px;"><label class="mt-checkbox"><input type="checkbox" id="checkbox29" class="md-check" value="1" name="credicart_extra_price_alert"/>Alan ile ilgili Uyarı Oluştur<span></span></label></div><p class="help-inline">Bu özelliği Temanızın desteklemesi gerekmektedir.</p></div>\n\
                                                        <div class="col-md-2"><input type="text" class="form-control" name="credicart_price" value="" /></div>\n\
                                                        <div class="col-md-2"><select class="form-control" data-extra="extra_field_workable_type" name="credicart_price_unit"><option value="---">Para Birimi </option><option value="dl">Dolar</option><option value="eu">Euro</option></select></div>\n\
                                                        <div class="col-sm-1"><button  class="btn btn-xs btn-circle btn-danger " data-extra="extra_field_workable_type" data-extra_price="remove_extra" data-extra_price_mode="credicart" > <span class="fa fa-trash"></span></button> </div>\n\
                                                        </div>\n\
                                                    </div>';
                            break;
                        case"atthedoor":
                            extra_price_html += ' <div class="form-group card" data-extra_price="atthedoor">\n\
                                                        <div class="row">\n\
                                                        <label class="col-md-2 control-label">Kapıda Ödeme</label>\n\
                                                        <div class="col-md-2"><div class="mt-checkbox-list" style="margin-top: 8px;"><label class="mt-checkbox"><input type="hidden" value="1" name="atthedoor"/><input type="checkbox" id="checkbox29" class="md-check" value="1" name="atthedoor_extra_price"/>Extra Ücret Alanı Ekle<span></span></label></div></div>\n\
                                                        <div class="col-md-3"><div class="mt-checkbox-list" style="margin-top: 8px;"><label class="mt-checkbox"><input type="checkbox" id="checkbox29" class="md-check" value="1" name="atthedoor_extra_price_alert"/>Alan ile ilgili Uyarı Oluştur<span></span></label></div><p class="help-inline">Bu özelliği Temanızın desteklemesi gerekmektedir.</p></div>\n\
                                                        <div class="col-md-2"><input type="text" class="form-control" name="atthedoor_price" value="" data-extra="extra_field_workable_type" /></div>\n\
                                                        <div class="col-md-2"><select class="form-control" name="atthedoor_price_unit" data-extra="extra_field_workable_type"><option value="---">Para Birimi </option><option value="dl">Dolar</option><option value="eu">Euro</option></select></div>\n\
                                                        <div class="col-sm-1"><button class="btn btn-xs btn-circle btn-danger " data-extra_price="remove_extra" data-extra_price_mode="atthedoor" > <span class="fa fa-trash"></span></button> </div>\n\
                                                        </div>\n\
                                                    </div>';
                            break;
                        case"bank":
                            extra_price_html += ' <div class="form-group card" data-extra_price="bank">\n\
                                                        <div class="row">\n\
                                                        <label class="col-md-2 control-label">Banka Havalesi</label>\n\
                                                        <div class="col-md-2"><div class="mt-checkbox-list" style="margin-top: 8px;"><label class="mt-checkbox"><input type="hidden" value="1" name="bank"/><input type="checkbox" id="checkbox29" class="md-check" value="1" name="bank_extra_price"/>Extra Ücret Alanı Ekle<span></span></label></div></div>\n\
                                                        <div class="col-md-3"><div class="mt-checkbox-list" style="margin-top: 8px;"><label class="mt-checkbox"><input type="checkbox" id="checkbox29" class="md-check" value="1" name="bank_extra_price_alert"/>Alan ile ilgili Uyarı Oluştur<span></span></label></div><p class="help-inline">Bu özelliği Temanızın desteklemesi gerekmektedir.</p></div>\n\
                                                        <div class="col-md-2"><input type="text" class="form-control" name="bank_price" value="" data-extra="extra_field_workable_type" /></div>\n\
                                                        <div class="col-md-2"><select class="form-control" name="bank_price_unit" data-extra="extra_field_workable_type"><option value="---">Para Birimi </option><option value="dl">Dolar</option><option value="eu">Euro</option></select></div>\n\
                                                        <div class="col-sm-1"><button  class="btn btn-xs btn-circle btn-danger " data-extra_price="remove_extra" data-extra_price_mode="bank" > <span class="fa fa-trash"></span></button> </div>\n\
                                                        </div>\n\
                                                    </div>';
                            break;
                        case"inplace":
                            extra_price_html += ' <div class="form-group card" data-extra_price="inplace">\n\
                                                        <div class="row">\n\
                                                        <label class="col-md-2 control-label">Yerinde Ödeme</label>\n\
                                                        <div class="col-md-2"><div class="mt-checkbox-list" style="margin-top: 8px;"><label class="mt-checkbox"><input type="hidden" value="1" name="inplace"/><input type="checkbox" id="checkbox29" class="md-check" value="1" name="inplace_extra_price"/>Extra Ücret Alanı Ekle<span></span></label></div></div>\n\
                                                        <div class="col-md-3"><div class="mt-checkbox-list" style="margin-top: 8px;"><label class="mt-checkbox"><input type="checkbox" id="checkbox29" class="md-check" value="1" name="inplace_extra_price_alert"/>Alan ile ilgili Uyarı Oluştur<span></span></label></div><p class="help-inline">Bu özelliği Temanızın desteklemesi gerekmektedir.</p></div>\n\
                                                        <div class="col-md-2"><input type="text" class="form-control" name="inplace_price" value="" data-extra="extra_field_workable_type"/></div>\n\
                                                        <div class="col-md-2"><select class="form-control" name="inplace_price_unit" data-extra="extra_field_workable_type"><option value="---">Para Birimi </option><option value="dl">Dolar</option><option value="eu">Euro</option></select></div>\n\
                                                        <div class="col-sm-1"><button  class="btn btn-xs btn-circle btn-danger " data-extra_price="remove_extra" data-extra_price_mode="inplace" > <span class="fa fa-trash"></span></button> </div>\n\
                                                        </div>\n\
                                                    </div>';
                            break;
                    }

                    $(this).parents("form").find('[data-settings="extra_price_section"]').append(extra_price_html)
                    $('[data-extra_price="remove_extra"]').off();
                    $('[data-extra_price="remove_extra"]').on("click", function (e) {
                        e.preventDefault();
                        let extra_price_mode = $(this).data("extra_price_mode")
                        $(this).parents('[data-extra_price="' + extra_price_mode + '"]').remove();
                        let extra_price_seccode = $(this).data("extra_price_seccode")
                        if (typeof extra_price_seccode !== "undefined") {
                            //db'den silme yapmamın gerekli
                        }
                    })
                } else {
                    alert("Bir Ekstra Bedel Ekli bulunmaktadır. Lütfen başka bir seçenek seçin")

                }
            } else {
                alert("Bir Ekstra Ücretlendirme Seçimi Yapın")
            }
        })
    }

    var number_mask = function () {
        $('[data-settings="number_mask"]').each(function () {
            new AutoNumeric(this, {currencySymbol: ' TL ', currencySymbolPlacement: 's'})
        })
    }

    var rawvalue = function () {
        $('[data-settings="number_mask"]').on("keydown", function () {
            console.log($(this).AutoNumeric("rawValue"))
        })
    }

    var remove_extra_price = function () {
        $('[data-extra_price="remove_extra"]').on("click", function (e) {
            e.preventDefault();
            let extra_price_mode = $(this).data("extra_price_mode")
            $(this).parents('[data-extra_price="' + extra_price_mode + '"]').remove();
        })
    }



    return {
        init: function () {
            handleBootstrapMaxlength()
            handletaxoffice()
            handleadres()
            handlebank()
            add_currency()
            product_unit()
            add_product_extrprice()
            currency_remove()
            number_mask()
            rawvalue()
            remove_extra_price()
            change_extra_field_workable_type()
        }
    }
}();


jQuery(document).ready(function () {
    page_settings.init(); // init metronic core componets
});