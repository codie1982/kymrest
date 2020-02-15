var group_values = function () {
    var sort_values = function () {
        var count = 1;
        $("ul.sortable_group_fields li").each(function () {
            $(this).find('input.options_line').val(count);
            count++;
        })
        $(".sortable_group_fields").sortable({
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
                $("ul.sortable_group_fields li").each(function () {
                    $(this).find('input.options_line').val(count);
                    count++;
                })
            }
        });
    }
    var remove = function () {
        $('[data-group_values="remove_fields"]').on("click", function (e) {
            e.preventDefault()
            var key = $(this).data("key")
            if (typeof key == "undefined") {
                $(this).parents("li").fadeOut(500, function () {
                    $(this).remove();
                })
            } else {
                const component_run_options = {
                    component_name: "group_values",
                    component_action: "remove",
                    component_object: {"group_fields_value_id": key},
                };
                component_run.run(component_run_options)
                $(this).parents("li").fadeOut(500, function () {
                    $(this).remove();
                })
            }
        })
    }
    return {
        init: function () {
            sort_values();
            remove();

        }
    }
}();
jQuery(document).ready(function () {
    group_values.init();
});