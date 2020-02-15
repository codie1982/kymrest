var module_settings_form = function () {
    var module_form = function () {
        let moduleoptions = {
            component_name: "module_settings_form",
            secret_number: false,
            formGroup: false,
            templateStyle: [
                {
                    parameter: "background",
                    value: "#fff",
                }
            ],
            content: [],
            form_complete: function () {
//                $('[data-module="remove_key"]').off();
//                $('[data-module="remove_key"]').on("click", function (e) {
//                    e.preventDefault();
//                    let module_key = $(this).data("module_key");
//                    if (typeof module_key !== "undefined") {
//                        console.log("Anahtar Silinecek")
//                    } else {
//
//                        $(this).parent().parent().parent().hide(500, function () {
//                            $(this).remove();
//                        })
//                    }
//                })
            }
        };

        var predata = document.querySelectorAll('[data-module_general_settings]');
        if (predata.length !== 0) {
            for (let i = 0; i < predata.length; i++) {
                moduleoptions.content = (JSON.parse(atob(predata[i].getAttribute("data-json"))));
            }
        }
        $(".module_form_general_settings").makeForm(moduleoptions);



//        var addmodule_key = document.querySelector('[data-module="addkey"]');
//        addmodule_key.addEventListener("click", function (e) {
//            e.preventDefault();
//            var adddata = document.querySelector('[reset-module_general_settings]');
//            moduleoptions.content = (JSON.parse(atob(adddata.getAttribute("data-json"))));
//            $(".module_form_general_settings").makeForm(moduleoptions);
//
//        })




        var modulesdata = document.querySelectorAll('[data-modules]');
        if (modulesdata.length !== 0) {
            for (let i = 0; i < modulesdata.length; i++) {
                let module_name = modulesdata[i].getAttribute("module_name");
                moduleoptions.content = (JSON.parse(atob(modulesdata[i].getAttribute("data-json"))));
                $("." + module_name).makeForm(moduleoptions);
            }
        }
    }
    return {
        init: function () {
            module_form();
        }
    }
}();
jQuery(document).ready(function () {
    module_settings_form.init(); // init metronic core componets
});