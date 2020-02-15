var returned_order = function () {
    return {
        init: async  function () {
            const options = {
                component_name: "returned_order",
                start: 0,
                end: 5 
            }
            /* */
 
            $("#returned_order").data_table(options);
        }
    }
}()

$(document).ready(function () {
    returned_order.init(); // init metronic core componets
});