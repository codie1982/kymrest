var customer_table = function () {
    return {
        init: async function () {
            const options = {
                component_name: "customer_table",
                action: "getdata",
                start: 0,
                end: 5,
                search: true,
                multiple_search: true,
                search_placeholder: "Kullanıcı İsmi|mail Adresi|Kullanıcı Kodu|telefon Numarası",
                actionfunction: function (data) {
                    component_run.init();
                    form.init();
                },
            }
            /* */

            $("#customer_table").data_table(options);
        }
    }
}()

$(document).ready(function () {
    customer_table.init(); // init metronic core componets
});