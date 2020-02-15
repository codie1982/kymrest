var confirm_button = function () {
    return {
        init: function () {
            $('[data-show="job_confirm"]').off()
            $('[data-show="job_confirm"]').on("click", function (e) {
                e.preventDefault()
                var $this = $(this)
                const options = {
                    component_name: "job_short_table",
                    action: "confirm_job",
                    data: {job_id: $(this).data("key")},
                    before: function () {

                    },
                    complete: function (data) {
                        if (data.sonuc) {
                            // component_run.init();
                            //form.init();
                            console.log(data)
                            $this.parents("tr").find("td").each(function () {
                                $(this).css({background: data.background})
                            })

                            $this.attr("data-show", "job_prepare")

                            $this.text("Hazırlandı")
                            prepare_button.init()
                        }
                    }
                }

                makexhr.send(options)
            })
        }
    }
}()

$(document).ready(function () {
    confirm_button.init(); // init metronic core componets
});