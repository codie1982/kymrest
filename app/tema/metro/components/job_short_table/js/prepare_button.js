var prepare_button = function () {
    return {
        init: function () {
            $('[data-show="job_prepare"]').off()
            $('[data-show="job_prepare"]').on("click", function (e) {
                e.preventDefault()
                var $this = $(this)
                const options = {
                    component_name: "job_short_table",
                    action: "prepare_job",
                    data: {job_id: $(this).data("key")},
                    before: function () {

                    },
                    complete: function (data) {
                        if (data.sonuc) {
                            // component_run.init();
                            //form.init();
                            console.log(data)
                            // $('[component_name="job_detail_list"]').html(data.content)

                            $this.parents("tr").find("td").each(function () {
                                $(this).css({"background-color": data.background})
                            })
                            $this.attr("data-show", "job_delivery")
                            $this.text("Yolda")
                            delivery_button.init()

                        }
                    }
                }
                makexhr.send(options)
            })
        }
    }
}()

$(document).ready(function () {
    prepare_button.init(); // init metronic core componets
});