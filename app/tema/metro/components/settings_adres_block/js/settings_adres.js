var settings_adres = function () {
    var company_adres = function () {

        let options = {
            component_name: "settings_adres_block",
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
        console.log(predata)
        if (typeof predata.length !== "undefined") {
            for (let i = 0; i < predata.length; i++) {
                options.content = (JSON.parse(atob(predata[i].getAttribute("data-json"))));
            }
        } else {
            var predata = document.querySelector('[reset-' + options.component_name + ']');
            options.content = (JSON.parse(atob(predata.getAttribute("data-json"))));
        }

        $(".adres_content").makeForm(options);
        $('[data-adres="add"]').on("click", function (e) {
            e.preventDefault();
            let options = {
                component_name: "settings_adres_block",
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
            $(".adres_content").makeForm(options).addnew();
        })


    }
    return {
        init: function () {
            company_adres();
        }
    }
}();
jQuery(document).ready(function () {
    settings_adres.init(); // init metronic core componets
});