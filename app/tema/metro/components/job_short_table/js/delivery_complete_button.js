var delivery_complete_button = function () {
    return {
        init: function () {
            $('[data-show="job_delivery_complete"]').off()
            $('[data-show="job_delivery_complete"]').on("click", function (e) {
                e.preventDefault()
                var $this = $(this)
                const options = {
                    component_name: "job_short_table",
                    action: "delivery_complete_job",
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
                            $this.attr("data-show", "job_complete")
                            $this.text("Tamamlandı")
                            complete_button.init()
                        }
                    }
                }
                makexhr.send(options)
            })
        }
    }
}()

$(document).ready(function () {
    delivery_complete_button.init(); // init metronic core componets
});