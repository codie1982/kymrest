var pause_button = function () {
    var public_state = function () {
        $('[data-public_state]').on("click", function (e) {
            e.preventDefault()
            var $this = $(this)

            var public_state = $this.data("public_state");

            const component_name = $this.attr("component_title")
            const component_action = public_state
            const component_data = $this.attr("component_data")



            const options = {
                component_name: component_name,
                action: component_action,
                data: {product_id: component_data},
                complete: function (data) {
                    if (data.sonuc) {

                        if (public_state == "pause_product") {
                            $this.attr("data-pause_product", "public_product");
                        } else {
                            $this.attr("data-public_product", "pause_product");
                        }


                        if ($this.hasClass(("label-success"))) {
                            $this.removeClass(("label-success"))
                            $this.addClass(("label-danger"))
                        } else {
                            $this.removeClass(("label-danger"))
                            $this.addClass(("label-success"))
                        }



                        if ($this.children("span").hasClass(("fa-play"))) {
                            $this.children("span").removeClass(("fa-play"))
                            $this.children("span").addClass(("fa-pause"))
                        } else {
                            $this.children("span").removeClass(("fa-pause"))
                            $this.children("span").addClass(("fa-play"))
                        }

                    }
                }
            }

            makexhr.send(options)
        })

    }

    return {
        init: function () {
            public_state();


        }
    }
}()

$(document).ready(function () {
    pause_button.init(); // init metronic core componets
});