var category_table = function () {
    return {
        init: function () {
            const options = {
                component_name: "category_table",
                start: 0,
                end: 5,
                actionfunction: function (data) {
                    component_run.init();
                    form.init();
                    short_table.init();
                },
            }
            let category_input = document.querySelector('[data-category_id]');
            if (category_input === null) {
                options.selected_id = 0;
            } else {
                options.selected_id = category_input.value;
            }
            $("#category_table").data_table(options);
        }
    }
}()

$(document).ready(function () {
    category_table.init(); // init metronic core componets
});