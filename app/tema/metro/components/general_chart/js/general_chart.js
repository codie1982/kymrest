var general_chart = function () {
    var addActiveChart = () => {
        var chart_list = $(".chart_list label");
        var time_list = $(".time-list li");
        var selected;
        areaChart(chart_list, time_list)
        $('[data-chart]').on("click", function () {
            selected = $(this).data("chart");
            setChart(chart_list, selected)
            areaChart(chart_list, time_list)
        })
        $('[data-time]').on("click", function () {
            selected = $(this).data("time")
            //setTime(timeList, selected)
            $(this).parents("ul").find("li").each(function () {
                if ($(this).children("a").data("time") == selected) {
                    if ($(this).hasClass("active")) {
                        $(this).removeClass("active")
                    } else {
                        $(this).addClass("active")
                    }
                } else {
                    $(this).removeClass("active")
                }
            })
            areaChart(chart_list, time_list)
        })
        //

//        chart_list.click(function (e) {
//            e.preventDefault();
//            selected = $(this).children('input[type="checkbox"]').attr("data-chart")
//            console.log($(this))
//            //setChart(chart_list, selected)
//            //areaChart(chart_list)
//        })
    }
    //component_controller_url({component_name: "general_chart"})
    function addChart(chart_list) {
        let selectedChart = [];
        if (typeof chart_list !== "undefined") {
            chart_list.each(function () {
                if ($(this).hasClass("active")) {
                    let dt = $(this).children("input").attr("data-chart")
                    selectedChart.push(dt)
                }
            })
        }

        return selectedChart;
    }
    function addTime(time_list) {
        let selectedTime = [];
        if (typeof time_list !== "undefined") {
            time_list.each(function () {
                if ($(this).hasClass("active")) {
                    let dt = $(this).children("a").attr("data-time")
                    if (dt == "custom") {
                        var start_time = $("#custom_time_start").val()
                        var end_time = $("#custom_time_end").val()
                        selectedTime.push(start_time)
                        selectedTime.push(end_time)
                    } else {
                        selectedTime.push(dt)
                    }

                }
            })
        }

        return selectedTime;
    }
    function setChart(chart_list, selected) {
        chart_list.each(function () {
            if ($(this).children("input").attr("data-chart") == selected) {
                if ($(this).hasClass("active")) {
                    $(this).removeClass("active")
                } else {
                    $(this).addClass("active")
                }
            }
        })
    }
    //component_controller_url({component_name: "general_donut_chart"})
    //`/api/chart_info/general/${selectedChart}/${selectedTime}`
    var areaChart = (chart_list, time_list) => {
        chart_area(addChart(chart_list), addTime(time_list));
        function chart_area(selectedChart, selectedTime) {
            if (typeof selectedChart !== "undefined") {
                if (selectedChart.length !== 0 && selectedTime.length !== 0) {

                    const options = {
                        component_name: "general_chart",
                        action: "getdata",
                    }
                    //parameter: [selectedChart, selectedTime],
                    $.ajax({type: "post",
                        url: component_controller_url(options),
                        data: {"data_type": selectedChart, "time_type": selectedTime},
                        dataType: "json",
                        beforeSend: function () {
                            $("#area-chart").html("Yükleniyor...")
                        },
                        success: function (data) {
                            $("#area-chart").html("")
                            if (data.sonuc) {
                                var config = {
                                    data: data.chart,
                                    xkey: data.chart_xkey,
                                    ykeys: data.chart_ykey,
                                    labels: data.chart_label,
                                    xLabelFormat: function (x) {
                                        return x.src.y;
                                    },
                                    yLabelFormat: function (y) {
                                        return y.toString();
                                    },
                                    fillOpacity: 0.2,
                                    hideHover: 'auto',
                                    parseTime: false,
                                    smooth: true,
                                    behaveLikeLine: false,
                                    resize: true,
                                    pointFillColors: data.chart_color,
                                    pointStrokeColors: ['gray'],
                                    hideHover: true,
                                    pointSize: 3,
                                    lineColors: data.chart_color,
                                    grid: false,
                                    axes: false,
                                    padding: 1
                                };
                                config.element = 'area-chart';
                                Morris.Area(config);
                            } else {
                                toastr["error"](data.msg)
                            }
                        }
                    });
                } else {
                    $("#area-chart").html("Bir Grafik Alanı Seçin")
                }

            }
        }
    }
    return {
        init: async function () {
            addActiveChart(); // handle adres Blok
            areaChart(); // handle adres Blok
        }
    }
}()
$(document).ready(function () {
    general_chart.init(); // init metronic core componets
});