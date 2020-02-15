


var job_table = function () {
    return {
        init: async function () {
            const options = {
                component_name: "job_table",
                start: 0,
                end: 5,
                search: true,
                multiple_search: true,
                search_placeholder: "İşleriniz ilgili arama yapın",
                actionfunction: function (data) {
                    component_run.init();
                    form.init();
                },

            }
            /* */

            $("#job_table").data_table(options);
        }
    }
}()

$(document).ready(function () {
    job_table.init(); // init metronic core componets
});