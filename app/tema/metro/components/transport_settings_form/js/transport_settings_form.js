/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var transport_settings_form = function () {
    var product_transport_function = function () {
        $('[data-transport_settings="workable_type"]').on("change", function () {
            var selected_value = $(this).val();
            if (selected_value == "constant") {
                $(this).parents('[component_name="transport_settings_form"]').find('[data-check]').prop("disabled", false)
            } else if (selected_value == "changeable") {
                $(this).parents('[component_name="transport_settings_form"]').find('[data-check]').prop("disabled", true)
            }
        })
    }
    var transport_location = function () {
        $('[data-transport_settings="transport_truck_application"]').on("change", function () {
            if ($(this).prop("checked")) {
                $('[ data-section="adres"]').show()
            } else {
                $('[ data-section="adres"]').hide()
            }
        })
    }
    return {
        init: function () {
            product_transport_function();
            transport_location();
        }
    }
}();
jQuery(document).ready(function () {
    transport_settings_form.init(); // init metronic core componets
});