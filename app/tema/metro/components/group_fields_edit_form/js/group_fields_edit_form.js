/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var group_fields_edit_form = function () {
    var remove_groups = function () {

        $('[data-group_fields_edit_form="remove_groups"]').on("click", function (e) {
            e.preventDefault();
            let key = $(this).data("key")
            const options = {
                component_name: "group_fields_edit_form",
                component_action: "remove_all",
                component_object: {"group_fields_id": key},
            }
            component_run.run(options)
        })


    }

    var remove_values = function () {
        $('[data-group_fields_edit_form="remove_group_fields"]').on("click", function (e) {
            e.preventDefault();
            let key = $(this).data("key")
            if (typeof key == "undefined") {
                $(this).parents("li").fadeOut(500, function () {
                    $(this).remove();
                })
            } else {
                const options = {
                    component_name: "group_values",
                    component_action: "remove",
                    component_object: {"group_fields_value_id": key},
                }
                component_run.run(options);

                $(this).parents("li").fadeOut(500, function () {
                    $(this).remove();
                })
            }

        })
    }
    var addvalue = function () {
        $('[data-group_fields_edit_form="add_fields" ]').off()
        $('[data-group_fields_edit_form="add_fields" ]').on("click", function (e) {
            e.preventDefault();
            const component_run_options = {
                component_name: "group_values",
                component_action: "multireload",
                $this: $(this),
                parents: "form-body",
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
    var change = function () {
        $('[data-category="select_group_fields"]').on("change", function () {
            var value = $(this).val();
            const options = {
                component_name: "group_fields_form",
                component_action: "get_group_data",
                component_object: {"selected_group_id": value},
            }
            component_run.run(options);

        })
    }
    return {
        init: function () {
            remove_values();
            remove_groups();
            addvalue();
            change();

        }
    }
}();
jQuery(document).ready(function () {
    group_fields_edit_form.init(); // init metronic core componets
});