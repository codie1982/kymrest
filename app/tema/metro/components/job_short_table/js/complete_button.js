var complete_button = function () {
    return {
        init: function () {
            $('[data-show="job_complete"]').off()
            $('[data-show="job_complete"]').on("click", function (e) {
                e.preventDefault()
                var $this = $(this)
                const options = {
                    component_name: "job_short_table",
                    action: "complete_job",
                    data: {job_id: $(this).data("key")},
                    before: function () {

                    },
                    complete: function (data) {
                        if (data.sonuc) {
                            // component_run.init();
                            //form.init();
                            // $('[component_name="job_detail_list"]').html(data.content)

                            $this.parents("tr").find("td").each(function () {
                                $(this).css({"background-color": data.background})
                            })
                            
                            
                            $this.parents("tr").hide("500", function () {
                                $(this).remove()
                            })


                        }
                    }
                }
                makexhr.send(options)
            })
        }
    }
}()

$(document).ready(function () {
    complete_button.init(); // init metronic core componets
});