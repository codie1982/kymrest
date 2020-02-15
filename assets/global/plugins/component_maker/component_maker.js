var component_maker = function () {
    component_controller_url = function (options) {
        var defaults = {
            component_name: "",
            action: "",
            parameter: [],
            url_parameter: "",
        }
//component_controller_url
//`/api/chart_info/general/${selectedChart}/${selectedTime}`
        var url_parameter = "";
        var settings = Object.assign({}, defaults, options)
        if (settings.parameter !== "") {
            settings.parameter.forEach(set_parameter)
        }
        function set_parameter(item, index) {
            settings.url_parameter += item + "/"
        }

        function set_url() {
            return `/component/${settings.component_name}/${settings.action}/${settings.url_parameter}`
        }

        return set_url()
    }
    return {
        init: function () {
            component_controller_url()
        }
    }
}();
jQuery(document).ready(function () {
    component_maker.init(); // init metronic core componets
});