/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var job_form_products_detail = function () {
    var buttons = function () {
        $('[data-product_detail_action]').on("click", function (e) {
            e.preventDefault();
            var amnout = $("#product_amount_input")
            var amnout_value = amnout.val()
            var gain = $(this).data("product_detail_action");
            if (gain == "plus") {
                amnout_value++
            } else if (gain == "minus") {
                amnout_value--
            }
            if (amnout_value <= 0) {
                amnout_value = 0;
            }
            amnout.val(amnout_value)
        })
    }
    var add_button = function () {
        $('[data-product="add_job_list"]').on("click", function (e) {
            e.preventDefault();

        })
    }

    var selected_payment_method = function () {
        $("#selected_product_payment_method").on("change", function () {
            var payment_select_box = $(this);
            var secret_key = payment_select_box.children("option:selected").attr("secret_key");
            var payment_method = payment_select_box.children("option:selected").val();
            var payment_price = payment_select_box.children("option:selected").attr("price");
            var payment_price_unit = payment_select_box.children("option:selected").attr("price_unit");
            if (secret_key !== "undefined") {
                $("#selected_product_payment_info").html(`
                        <input type="hidden" name="@job_product_fields$payment_method:${secret_key}" value="${payment_method}"/>
                        <input type="hidden" name="@job_product_fields$product_extra_price:${secret_key}" value="${payment_price}"/>
                        <input type="hidden" name="@job_product_fields$product_extra_price_unit:${secret_key}" value="${payment_price_unit}"/>
`)
            } else {
                $("#selected_product_payment_info").html(`
                        <input type="hidden" name="@job_product_fields$payment_method" value="${payment_method}"/>
                        <input type="hidden" name="@job_product_fields$product_extra_price" value="${payment_price}"/>
                        <input type="hidden" name="@job_product_fields$product_extra_price_unit" value="${payment_price_unit}"/>
`)
            }

        })


    }

    var select_product_options = () => {
//                    data-group_id="<?= $group->product_price_group_id ?>"
//                                                                   data-group_title="<?= $group->group_title ?>"
//                                                                   data-group_type="<?= $group->group_type ?>"
//                                                                   data-direction="<?= $option->direction ?>"
//                                                                   data-type="<?= $option->type ?>"
//                                                                   data-value="<?= $option->value ?>"
//                                                                   data-currency="<?= default_currency() ?>"

        $('[product_options]').on("change", function () {

            const pchecked = $(this).prop("checked");
            const product_options_sections = $("#product_options")
            const parent_key = $(this).data("parent_key")
            const secret_number = $(this).data("secret_number")
            const options_id = $(this).data("options_id")
            const job_id = $(this).data("job_id")
            const group_id = $(this).data("group_id")
            const group_title = $(this).data("group_title")
            const group_type = $(this).data("group_type")
            const price_title = $(this).data("price_title")
            const direction = $(this).data("direction")
            const type = $(this).data("type")
            const value = $(this).data("value")
            const currency = $(this).data("currency")

            var group_div = $("#" + group_id);// grup divini seçmek istiyoruz
            if (group_div.length == 0) {// grup div oluşmamış ise
                var iDiv = document.createElement('div'); // bir div oluşturuyoruz
                iDiv.id = group_id; // id sine Grup idsini atıyoruz
                product_options_sections.append(iDiv) // options divinin içine ekliyoruz
                group_div = $("#" + group_id) // group_div değişkeninine bu div seçiyoruz
            }
            if (pchecked) {
                if (group_type == "checkbox") { // input checked ise
                    group_div.append(`<input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$secret_number:${secret_number}" value="${secret_number}"/>`);// divin içine gerekli inputları oluşturuyoruz
                    group_div.append(`<input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$parent_key:${secret_number}" value="${parent_key}"/>`);// üst tablo değeri
                    group_div.append(`<input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$job_id:${secret_number}" value="${job_id}"/>`);// işin id numarası
                    group_div.append(`<input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$job_product_price_group_id:${secret_number}" value="${group_id}"/>`);// grup id numarası
                    group_div.append(`<input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$job_product_price_group_title:${secret_number}" value="${group_title}"/>`);// grup başlığı
                    group_div.append(`<input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$price_title:${secret_number}" value="${price_title}"/>`);// fiyat açıklama başlığı
                    group_div.append(`<input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$direction:${secret_number}" value="${direction}"/>`);// arttırım-azaltım yönü
                    group_div.append(`<input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$type:${secret_number}" value="${type}"/>`);// mikar - oran 
                    group_div.append(`<input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$value:${secret_number}" value="${value}"/>`);// değeri
                } else if (group_type == "radio") {
                    group_div.html(`
                            <input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$secret_number:${secret_number}" value="${secret_number}"/>
                            <input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$parent_key:${secret_number}" value="${parent_key}"/>
                            <input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$job_id:${secret_number}" value="${job_id}"/>
                            <input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$job_product_price_group_id:${secret_number}" value="${group_id}"/>
                            <input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$job_product_price_group_title:${secret_number}" value="${group_title}"/>
                            <input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$price_title:${secret_number}" value="${price_title}"/>
                            <input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$direction:${secret_number}" value="${direction}"/>
                            <input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$type:${secret_number}" value="${type}"/>
                            <input class="${options_id}" type="hidden" name="@job_products_price_options_value_fields$value:${secret_number}" value="${value}"/>
                    
`);// divin içine gerekli inputları oluşturuyoruz
                }
            } else {
                group_div.find("." + options_id).remove()
            }


        })
    }
    return {
        init: function () {
            buttons();
            add_button();
            selected_payment_method();
            select_product_options();
        }
    }
}();
jQuery(document).ready(function () {
    job_form_products_detail.init(); // init metronic core componets
});