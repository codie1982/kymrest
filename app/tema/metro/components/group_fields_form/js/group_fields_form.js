/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var group_fields_form = function () {
    var addvalue = function () {
        $('[data-group_fields_form="add_fields"]').off()
        $('[data-group_fields_form="add_fields"]').on("click", function (e) {
            e.preventDefault();
            const component_run_options = {
                component_name: "group_values",
                component_action: "reload",
            };
            if ($('[component_name="group_values"]').find("ul").length == 0) {
                component_run_options.component_key = "addul"
                component_run_options.component_data = "true"
            } else {
                component_run_options.component_key = "addul"
                component_run_options.component_data = "false"
            }
            component_run.run(component_run_options)


        })
    }

    var remove_groups = function () {

        $('[data-group_fields_form="remove_groups"]').on("click", function (e) {
            e.preventDefault();
            let key = $(this).data("key")
            const options = {
                component_name: "group_fields_form",
                component_action: "remove_all",
                component_object: {"group_fields_id": key},
            }
            component_run.run(options)
        })


    }
    return {
        init: function () {
            addvalue();
            remove_groups();

        }
    }
}();
jQuery(document).ready(function () {
    group_fields_form.init(); // init metronic core componets
});