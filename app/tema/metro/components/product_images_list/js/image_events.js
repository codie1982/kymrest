var image_events = function () {
    return {
        init: function () {
            $('[data-product_image="remove"]').on("click", function (e) {
                e.preventDefault()
                $(this).parents("li").remove()
            })
            var count = 1;
            $("ul.sortable li").each(function () {
                $(this).find('input.image_line_id').val(count);
                count++;
            })
            $(".sortable").sortable({
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
                    $("ul.sortable li").each(function () {
                        $(this).find('input.image_line_id').val(count);
                        count++;
                    })
                }
            });

        }
    }
}()