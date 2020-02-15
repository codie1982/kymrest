var complete_order = function () {
    return {
        init: async function () {
            const options = {
                component_name: "complete_order",
                start: 0,
                end: 5
            }
            /* */

            $("#job_complete_order").data_table(options);
        }
    }
}()
//window.onload = () => {
//    complete_order.init(); // init metronic core componets
//}

$(document).ready(function () {
    complete_order.init(); // init metronic core componets
});