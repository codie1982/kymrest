var waiting_order = function () {
    return {
        init: async  function () {
            const options = {
                component_name: "waiting_order",
                start: 0,
                end: 5
            }
            /* */

            $("#waiting_order").data_table(options);
        }
    }
}()
//window.onload = () => {
//
//}

$(document).ready(function () {
    waiting_order.init(); // init metronic core componets
});