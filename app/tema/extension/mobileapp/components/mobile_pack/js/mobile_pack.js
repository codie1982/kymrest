/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var mobile_pack = function () {
    var _pack = function () {

        let options = {
            component_name: "mobile_pack",
            secret_number: false,
            formGroup: true,
            templateStyle: [
                {
                    parameter: "background",
                    value: "#fff",
                }
            ],
            content: [],
            form_complete:function(){
                component_run.init()
                slider_images_list.init()
            }
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
            $(".application").makeForm(options);

    }

    return {
        init: function () {
            _pack();
        }
    }
}();
jQuery(document).ready(function () {
    mobile_pack.init(); // init metronic core componets
});