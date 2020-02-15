var job_detail_list = function () {
    return {
        init: async function () {
             component_run.init();
        }
    }
}()

$(document).ready(function () {
    job_detail_list.init(); // init metronic core componets
});