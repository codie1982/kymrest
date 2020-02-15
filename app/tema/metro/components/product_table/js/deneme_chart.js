var deneme_chart = function () {
    return {
        init: async function () {
            setTimeout(function () {
                var morris_element = $('[name="morris_element"]');
                //console.log(morris_element)
                for (let i = 0; i < morris_element.length; i++) {
                    let el = morris_element[i].value;
                    var rand1 = Math.floor(Math.random() * 20) + 1
                    var rand2 = Math.floor(Math.random() * 20) + 1
                    var rand3 = Math.floor(Math.random() * 20) + 1
                    var rand4 = Math.floor(Math.random() * 20) + 1
                    var rand5 = Math.floor(Math.random() * 20) + 1
                    new Morris.Line({
                        // ID of the element in which to draw the chart.
                        element: el,
                        // Chart data records -- each entry in this array corresponds to a point on
                        // the chart.
                        data: [
                            {year: '2008', value: rand1},
                            {year: '2009', value: rand2},
                            {year: '2010', value: rand3},
                            {year: '2011', value: rand4},
                            {year: '2012', value: rand5}
                        ],
                        // The name of the data record attribute that contains x-values.
                        xkey: 'year',
                        // A list of names of data record attributes that contain y-values.
                        ykeys: ['value'],
                        // Labels for the ykeys -- will be displayed when you hover over the
                        // chart.
                        labels: ['Value'],
                        grid: false,
                        axes: false,
                        padding: 1,
                        resize: false,
                        hideHover: "always",
                    });
                }
            }, 3000);



        }
    }
}()

$(document).ready(function () {
    deneme_chart.init(); // init metronic core componets
});