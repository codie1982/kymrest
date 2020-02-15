var group_fields_list_value = function () {
    var remove = function () {
        $('[data-group_fields_list_value="remove_item"]').on("click", function (e) {
            e.preventDefault();
            var $this = $(this);
            var key = $(this).data("key");
            if (typeof key == "undefined") {
                $this.parents(".category_group_fields").fadeOut(500, function () {
                    $(this).remove();
                })
            } else {
                data = {
                    category_group_field_id: key
                }
                options = {
                    component_name: "group_fields_list_value",
                    action: "remove",
                    data: data,
                    complete: function (data) {
                        if (data.sonuc) {
                            $this.parents(".category_group_fields").fadeOut(500, function () {
                                $(this).remove();
                            })
                        }
                    }
                }
                makexhr.send(options)
            }
        })
    }
    return {
        init: function () {
            remove();
        }
    }
}()
$(document).ready(function () {
    group_fields_list_value.init(); // init metronic core componets
});
