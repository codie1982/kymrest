var group_fields_list = function () {
    return {
        init: async function () {
            $('[data-category="select_group_fields"]').off();
            $('[data-category="select_group_fields"]').on("change", function () {
                var group_fields_id = $(this).val();
                var selected_text = $(this).children(":selected").text();
                const data = {
                    text: selected_text,
                    group_fields_id: group_fields_id,

                }
                const component_run_options = {
                    component_name: "group_fields_list_value",
                    component_action: "reload",
                    component_object: data

                };
                component_run.run(component_run_options)
            })
        }
    }
}()
$(document).ready(function () {
    group_fields_list.init(); // init metronic core componets
});
