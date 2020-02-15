var block_phone_company = function () {
    var customer_phone = function () {
        let options = {
            component_name: "block_phone_company",
            secret_number: true,
            formGroup: true,
            templateStyle: [
                {
                    parameter: "background",
                    value: "#ececec",
                },
                {
                    parameter: "padding",
                    value: "10px",
                },
                {
                    parameter: "border",
                    value: "1px solid #e1e1e1",
                },
                {
                    parameter: "box-shadow",
                    value: "0 0px 6px 1px gainsboro",
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
            $(".phone_content").makeForm(options);
        $('[data-phone="add"]').on("click", function (e) {
            e.preventDefault();
            let options = {
                component_name: "block_phone_company",
                secret_number: true,
                formGroup: true,
                max_count: $(this).data("max"),
                templateStyle: [
                    {
                        parameter: "background",
                        value: "#ececec",
                    },
                    {
                        parameter: "padding",
                        value: "10px",
                    },
                    {
                        parameter: "border",
                        value: "1px solid #e1e1e1",
                    },
                    {
                        parameter: "box-shadow",
                        value: "0 0px 6px 1px gainsboro",
                    }
                ],
                content: []
            };
            var predata = document.querySelector('[reset-' + options.component_name + ']');
            options.content = (JSON.parse(atob(predata.getAttribute("data-json"))));
            $(".phone_content").makeForm(options).addnew();
        })
    }
    return {
        init: function () {
            customer_phone();
        }
    }
}();
jQuery(document).ready(function () {
    block_phone_company.init(); // init metronic core componets
});