var socket_application = function () {
    return {
        init: async function () {
// var socket = io('http://192.168.1.5:3000/');
            var socket = io.connect('http://68.183.220.159:3000/');
            socket.on("refreshjoblist", (data) => {
                if (data.refresh_list) {

                    var $this = $(this)
                    const options = {
                        component_name: "job_short_table",
                        action: "get_last_data",
                        data: {job_id: 1},
                        before: function () {

                        },
                        complete: function (data) {
                            if (data.sonuc) {
                                //console.log(data)

                                //draw yapılacak tek bir table elde edilecek
                                var $this = $(this)
                                const options = {
                                    component_name: "job_short_table",
                                    action: "lastdraw",
                                    data: {
                                        "start": 1,
                                        "end": 1,
                                        "total": 1,
                                        "tabledata": data.result,
                                        "update": true,
                                    },
                                    before: function () {

                                    },
                                    complete: function (sdata) {
                                        if (sdata.sonuc) {
                                            component_run.init();
                                            form.init();
                                            console.log(sdata.render)

                                            $("#job_short_table").find("tbody").prepend(sdata.render)

                                            show_button.init()
                                            confirm_button.init()
                                            prepare_button.init()
                                            delivery_button.init()
                                            delivery_complete_button.init()
                                            complete_button.init()

                                        }
                                    }
                                }

                                makexhr.send(options)


                            }
                        }
                    }

                    makexhr.send(options)




//                    const options = {
//                        component_name: "job_short_table",
//                        component_action: "load"
//                    }
//                    component_run.run(options)
                }

            })
        }
    }
}()

$(document).ready(function () {
    socket_application.init(); // init metronic core componets
});