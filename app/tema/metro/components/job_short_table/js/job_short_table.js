var job_short_table = function () {
    return {
        init: async function () {
            const options = {
                component_name: "job_short_table",
                start: 0,
                end: 0,
                search: false,
                multiple_search: false,
                search_placeholder: "İşleriniz ilgili arama yapın",
                actionfunction: function (data) {
                    component_run.init();
                    form.init();
                    show_button.init()
                    confirm_button.init()
                    prepare_button.init()
                    delivery_button.init()
                    delivery_complete_button.init()
                    complete_button.init()
                },

            }
            $("#job_short_table").data_table(options);
        }
    }
}()

$(document).ready(function () {
    job_short_table.init(); // init metronic core componets
});