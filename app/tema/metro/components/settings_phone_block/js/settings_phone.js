var settings_phone = function () {
    var company_phone = function () {
        let options = {
            component_name: "settings_phone_block",
            secret_number: true,
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

        if (typeof predata.length !== "undefined") {
            for (let i = 0; i < predata.length; i++) {
                options.content = (JSON.parse(atob(predata[i].getAttribute("data-json"))));
            }
        } else {

        }

        $(".phone_content").makeForm(options);

        $('[data-phone="add"]').on("click", function (e) {
            e.preventDefault();
            let options = {
                component_name: "settings_phone_block",
                secret_number: true,
                formGroup: true,
                templateStyle: [
                    {
                        parameter: "background",
                        value: "#fff",
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
            company_phone();
        }
    }
}();
jQuery(document).ready(function () {
    settings_phone.init(); // init metronic core componets
});