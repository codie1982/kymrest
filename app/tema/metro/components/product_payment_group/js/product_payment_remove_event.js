var product_payment_remove_event = function () {
    var rmvent = function () {
        $('[data-product_form="remove_payment_method"]').on("click", function (e) {
            e.preventDefault();
            var key = $(this).data("key");
            if (typeof key !== "undefined") {
                var sendoptions = {
                    component_name: "product_payment_group_section",
                    action: "remove_payment_method",
                    data: {"key": key},
                    complete: function (data) {
                        $(this).parents(".payment_method_section").fadeOut("500", function () {
                            $(this).remove()
                        })
                    },
                }
                makexhr.send(sendoptions);
            } else {
                $(this).parents(".payment_method_section").fadeOut("500", function () {
                    $(this).remove()
                })
            }

        })
    }
    return {
        init: function () {
            rmvent();
        }
    }
}();
