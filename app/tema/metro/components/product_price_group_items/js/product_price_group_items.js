var product_price_group_items = function () {
    var remove = function () {
        $('[data-product_options_fields="remove_fields"]').off();
        $('[data-product_options_fields="remove_fields"]').on("click", function (e) {
            e.preventDefault();
            var $this = $(this);
            var key = $(this).data("key");
            if (typeof key !== "undefined") {
//                var sendoptions = {
//                    component_name: "product_price_options_section",
//                    action: "remove",
//                    data: {"product_price_option_id": key},
//                    complete: function (data) {
//                        $this.parents("li").fadeOut("500", function () {
//                            $(this).remove()
//                        })
//                    },
//                }
//                makexhr.send(sendoptions);
            } else {
                $(this).parents("li").fadeOut("500", function () {
                    $(this).remove()
                })
            }

        })
    }
    var sort = function () {
        var count = 1;
        $("ul.sortable_price_options li").each(function () {
            $(this).find('input.options_line').val(count);
            count++;
        })
        $(".sortable_price_options").sortable({
            opacity: 0.5,
            delay: 250,
            start: function (event, ui) {

            },
            stop: function (event, ui) {
                $("#event_list").html("Sonlandı")
            },
            sort: function (event, ui) {
                $("#event_list").html("Sıralandı")
            },
            activate: function (event, ui) {
                $("#event_list").html("activate")
            },
            update: function (event, ui) {
                count = 1;
                $("ul.sortable_price_options li").each(function () {
                    $(this).find('input.options_line').val(count);
                    count++;
                })
            }
        });
    }

    return {
        init: function () {
            remove();
            sort();
        }
    }
}();
jQuery(document).ready(function () {
    product_price_group_items.init(); // init metronic core componets
});