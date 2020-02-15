var register_form = function () {

    var register_frm = function () {
        let options = {
            component_name: "register_page",
            secret_number: false,
            formGroup: true,
            templateStyle: [
                {
                    parameter: "background",
                    value: "#fff",
                }
            ],
            content: [],
            form_complete: function () {
                password_check()
            }
        };
        var predata = document.querySelectorAll('[data-' + options.component_name + ']');
        if (predata.length !== 0) {
            for (let i = 0; i < predata.length; i++) {
                options.content = (JSON.parse(atob(predata[i].getAttribute("data-json"))));
            }
        }


        $(".register_form").makeForm(options);
    }

    var password_check = function () {
        var pass1 = document.querySelector('[name="@customer_siteaccount_fields$password"]')
        var pass2 = document.querySelector('[name="@plasebo_data$repassword"]')
        if (pass1.value != pass2.value) {
            alert("Şifreler uygun değil")
            return false;
        }
    }

    return {
        //main function to initiate the module
        init: function () {

            register_frm();


        }

    };

}();

jQuery(document).ready(function () {
    register_form.init();
});