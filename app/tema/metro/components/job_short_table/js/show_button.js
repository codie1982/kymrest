var show_button = function () {
    return {
        init: function () {
            $('[data-show="job_product_detail"]').on("click", function (e) {
                e.preventDefault()
                var $this = $(this)

//                const options = {
//                    component_name: "job_detail_list",
//                    component_action: "load",
//                    component_object: {job_id: $(this).data("key")},
//                }
                //component_run.run(options)


                const options = {
                    component_name: "job_detail_list",
                    action: "load",
                    data: {job_id: $(this).data("key")},
                    before: function () {

                    },
                    complete: function (data) {
                        if (data.sonuc) {
                            // component_run.init();
                            //form.init();
                            console.log(data)
                            $('[component_name="job_detail_list"]').html(data.content)

                            if (data.font == "500") {

                                $this.parents("tr").find(".eye").each(function () {
                                    if ($(this).hasClass("label-warning")) {
                                        $(this).removeClass("label-warning")
                                        $(this).addClass("label-success")
                                        $(this).html('<span class="fa fa-eye"></span>')
                                    }
                                    $(this).css({"font-weight": data.font})
                                })

                                $this.parents("tr").find(".text").each(function () {
                                    $(this).css({"font-weight": data.font})
                                })
                            }




                        }
                    }
                }

                makexhr.send(options)
            })
        }
    }
}()

$(document).ready(function () {
    show_button.init(); // init metronic core componets
});