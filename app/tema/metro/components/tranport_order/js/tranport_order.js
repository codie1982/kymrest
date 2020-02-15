var tranport_order = function () {
    return {
        init: async  function () {
            const options = {
                component_name: "tranport_order",
                start: 0,
                end: 5
            }
            /* */

            $("#tranport_order").data_table(options);
        }
    }
}()
//window.onload = () => {
//
//}

$(document).ready(function () {
    tranport_order.init(); // init metronic core componets
});