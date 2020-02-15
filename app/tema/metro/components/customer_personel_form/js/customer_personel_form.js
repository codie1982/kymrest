/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var customer_personel_form = function () {

    var personel_form = function () {
        let options = {
            component_name: "customer_personel_form",
            secret_number: false,
            formGroup: true,
            templateStyle: [
                {
                    parameter: "background",
                    value: "#fff",
                }
            ],
            content: []
        };
        var predata = document.querySelectorAll('[data-' + options.component_name + ']');
        if (predata.length !== 0) {
            for (let i = 0; i < predata.length; i++) {
                options.content = (JSON.parse(atob(predata[i].getAttribute("data-json"))));
            }
        } else {
            var predata = document.querySelector('[reset-' + options.component_name + ']');
            options.content = (JSON.parse(atob(predata.getAttribute("data-json"))));
        }
        $(".personel_form").makeForm(options);

    }
    var customer_type = function () {
        $('[data-customer="select-type"]').on("change", function () {
            var select_value = $(this).val();
            $("[data-customer-type]").each(function () {
                if ($(this).data("customer-type") == select_value) {
                    $(this).show();
                } else {
                    $(this).hide()
                }

            })
        })
    }
    return {
        init: function () {
            personel_form();
            customer_type();
        }
    }
}();
jQuery(document).ready(function () {
    customer_personel_form.init(); // init metronic core componets
});