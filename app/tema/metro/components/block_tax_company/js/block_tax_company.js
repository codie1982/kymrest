var block_tax_company = function () {
    var customer_tax = function () {

        let options = {
            component_name: "block_tax_company",
            secret_number: false,
            formGroup: false,
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
            if (predata !== null)
                options.content = (JSON.parse(atob(predata.getAttribute("data-json"))));
        }
        if (options.content !== "")
            $(".tax_content").makeForm(options);

    }
    return {
        init: function () {
            customer_tax();
        }
    }
}();
jQuery(document).ready(function () {
    block_tax_company.init(); // init metronic core componets
});