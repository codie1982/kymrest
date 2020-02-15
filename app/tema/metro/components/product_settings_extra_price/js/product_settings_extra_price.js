/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var product_settings_extra_price = function () {
    var extra_field_workable_type = function () {
        $('[data-extra_field_selected="extra_field_workable_type"]').on("change", function (e) {
            var selected_value = $(this).val();
            if (selected_value == "changeable") {
                $(this).parents('[component_name="product_settings_extra_price"]').find('[data-product_settings]').prop("disabled", true)
            } else if (selected_value == "constant") {
                $(this).parents('[component_name="product_settings_extra_price"]').find('[data-product_settings]').prop("disabled", false)
            }
        })
    }

    return {
        init: function () {
            extra_field_workable_type();
        }
    }
}();
jQuery(document).ready(function () {
    product_settings_extra_price.init(); // init metronic core componets
});