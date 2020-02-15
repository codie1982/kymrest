var transport_adres_block = function () {
    var delivery_adres = function () {
        let options = {
            component_name: "transport_adres_block",
            secret_number: true,
            formGroup: true,
            templateStyle: [
                {
                    parameter: "padding",
                    value: "10px",
                },
              
             
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
        $(".transport_adres_block_content").makeForm(options);
        $('[data-adres="add"]').on("click", function (e) {
            e.preventDefault();
            let options = {
                component_name: "transport_adres_block",
                secret_number: true,
                formGroup: true,
                templateStyle: [
                    {
                        parameter: "padding",
                        value: "10px",
                    },
                ],
                content: []
            };
            var predata = document.querySelector('[reset-' + options.component_name + ']');
            options.content = (JSON.parse(atob(predata.getAttribute("data-json"))));
            
            $(".transport_adres_block_content").makeForm(options).addnew();
        })
    }
    return {
        init: function () {
            delivery_adres();
        }
    }
}();
jQuery(document).ready(function () {
    transport_adres_block.init(); // init metronic core componets
});