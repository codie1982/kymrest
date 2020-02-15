var delivery_button = function () {
    return {
        init: function () {
            $('[data-show="job_delivery"]').off()
            $('[data-show="job_delivery"]').on("click", function (e) {
                e.preventDefault()
                var $this = $(this)
                const options = {
                    component_name: "job_short_table",
                    action: "delivery_job",
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
                            $this.attr("data-show", "job_delivery_complete")
                            $this.text("Teslim Edildi")
                            delivery_complete_button.init()
                        }
                    }
                }
                makexhr.send(options)
            })
        }
    }
}()

$(document).ready(function () {
    delivery_button.init(); // init metronic core componets
});