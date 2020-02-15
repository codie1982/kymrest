var favorite_button = function () {
    var add_favorite = function () {
        $('[data-favorite]').on("click", function (e) {
            e.preventDefault()
            var $this = $(this)

            var favorite_type = $this.data("favorite");

            const component_name = $this.attr("component_title")
            const component_action = favorite_type
            const component_data = $this.attr("component_data")



            const options = {
                component_name: component_name,
                action: component_action,
                data: {product_id: component_data},
                complete: function (data) {
                    if (data.sonuc) {

                        if (favorite_type == "add_favorite") {
                            $this.attr("data-favorite", "remove_favorite");
                        } else {
                            $this.attr("data-favorite", "add_favorite");
                        }

                        if ($this.children("span").hasClass(("fa-star-o"))) {
                            $this.children("span").removeClass(("fa-star-o"))
                            $this.children("span").addClass(("fa-star"))
                        } else {
                            $this.children("span").removeClass(("fa-star"))
                            $this.children("span").addClass(("fa-star-o"))
                        }

                    }
                }
            }
            console.log(options)
            makexhr.send(options)
        })

    }

    return {
        init: function () {
            add_favorite();
        }
    }
}()

$(document).ready(function () {
    favorite_button.init(); // init metronic core componets
});