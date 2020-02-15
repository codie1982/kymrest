/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var customer_company_form = function () {

    var company_form = function () {
        let options = {
            component_name: "customer_company_form",
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


        $(".company_form").makeForm(options);

    }

    return {
        init: function () {
            company_form();
   
        }
    }
}();
jQuery(document).ready(function () {
    customer_company_form.init(); // init metronic core componets
});