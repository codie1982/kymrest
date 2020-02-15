var donut_chart = function () {
    var donutChart = () => {
        const options = {
            component_name: "donut_chart",
            action: "getdata",
        }
        var scriptURL = component_controller_url(options);
        $.ajax({type: "post",
            url: scriptURL,
            data: {"pie": true},
            dataType: "json",
            beforeSend: function () {
                $("#pie_chart").html("Yükleniyor...")
            },
            success: function (data) {
                $("#pie_chart").html("")
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    Morris.Donut({
                        element: 'pie_chart',
                        padding: 1,
                        data: [
                            {label: data.complete_job_label, value: data.complete_job},
                            {label: data.return_job_label, value: data.return_job},
                            {label: data.basket_job_label, value: data.basket_job},
                            {label: data.incargo_job_label, value: data.incargo_job}
                        ]
                    });
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    return {
        init: async function () {
            donutChart(); // handle adres Blok
        }
    }
}()
$(document).ready(function () {
    donut_chart.init(); // init metronic core componets
});