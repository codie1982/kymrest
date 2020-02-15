var category_images_list = function () {
    var remove = function () {
        $('[data-category_image="remove"]').on("click", function (e) {
            e.preventDefault();
            var key = $('[data-key]').data("key");
            if (typeof key !== "undefined") {
                const obj = {
                    category_gallery_id: key,
                }
                const component_run_options = {
                    component_name: "category_gallery_form",
                    component_action: "remove_category_gallery",
                    component_object: obj
                }
                component_run.run(component_run_options)

                $(this).parents("li").fadeOut(500, function () {
                    $(this).remove()
                })
            } else {
                $(this).parents("li").fadeOut(500, function () {
                    $(this).remove()
                })
            }


        })
    }
    var sort = function () {
        var count = 1;
        $("ul.category_sortable li").each(function () {
            $(this).find('input.image_line_id').val(count);
            count++;
        })
        $(".category_sortable").sortable({
            opacity: 0.5,
            delay: 250,
            start: function (event, ui) {
            },
            stop: function (event, ui) {
            },
            sort: function (event, ui) {
            },
            activate: function (event, ui) {
            },
            update: function (event, ui) {
                var count = 1;
                $("ul.category_sortable li").each(function () {
                    $(this).find('input.image_line_id').val(count);
                    count++;
                })
            }
        });
    }

    return {
        init: function () {
            sort();
            remove();
        }
    }
}()