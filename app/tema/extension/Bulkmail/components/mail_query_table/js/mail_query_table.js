var mail_query_table = function () {
    return {
        init: async function () {
            const options = {
                component_name: "mail_query_table",
                start: 0,
                end: 15,
                search: true,
                multiple_search: true,
                search_placeholder: "Mail Adresi Yazın",
                actionfunction: function (data) {
                    component_run.init();
                    form.init();
                },

            }
            /* */

            $("#mail_query_table").data_table(options);
        }
    }
}()

$(document).ready(function () {
    mail_query_table.init(); // init metronic core componets
});