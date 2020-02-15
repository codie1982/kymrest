var user_settings_form = function () {
    var customer_settings_form = function () {
        let options = {
            component_name: "user_settings_form",
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
            if (predata !== null)
                options.content = (JSON.parse(atob(predata.getAttribute("data-json"))));
        }

        if (options.content !== "")
            $(".settings_customer_form").makeForm(options);
    }



    var supermen_tag;
    var customer_tag;
    var customer = function () {
        customer_tag = $("#customer")
        customer_tag.tagsinput();
    }
    var supermen = function () {
        supermen_tag = $("#supermen")
        supermen_tag.tagsinput();
    }


    return {
        init: function () {
            customer_settings_form();
            supermen();
            customer();

        }
    }
}();
jQuery(document).ready(function () {
    user_settings_form.init(); // init metronic core componets
});