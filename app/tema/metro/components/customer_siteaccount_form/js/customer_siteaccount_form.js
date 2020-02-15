var customer_siteaccount_form = function () {

    var mail_form = function () {
        let options = {
            component_name: "customer_siteaccount_form",
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

        }

        console.log(options)
        $(".mail_form").makeForm(options);



    }
    return {
        init: function () {
            mail_form()
        }
    }
}();
jQuery(document).ready(function () {
    customer_siteaccount_form.init(); // init metronic core componets
});