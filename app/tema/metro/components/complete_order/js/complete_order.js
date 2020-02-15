var complete_order = function () {
    return {
        init: async function () {
            const options = {
                component_name: "complete_order",
                start: 0,
                end: 5
            }
            /* */

            $("#complete_order").data_table(options);
        }
    }
}()

$(document).ready(function () {
    complete_order.init(); // init metronic core componets
});