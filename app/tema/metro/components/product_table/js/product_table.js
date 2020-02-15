var product_table = function () {
    
    return {
        init: async function () {
            const options = {
                component_name: "product_table",
                start: 0,
                end: 15,
                search: true,
                multiple_search: true,
                search_placeholder: "Ürün Araması Yapın",
                actionfunction: function (data) {
                    component_run.init();
                    favorite_button.init();
                    pause_button.init();
                    form.init();
                },

            }
            /* */

            $("#product_table").data_table(options);
        }
    }
}()

$(document).ready(function () {
    product_table.init(); // init metronic core componets
});