var library_content_header = function () {
    var view_list = function () {
        $(".library-view-list li").on("click", function (e) {
            e.preventDefault();
            // $(this).hasClass
            var viewtype = $(this).data("view_type")
            $(".library-view-list li").each(function () {
                $(this).removeClass("select")
            })
            $(this).addClass("select")
        })
    }
    var type_list = function () {
        $(".library-type-list li").on("click", function (e) {
            e.preventDefault();
            var media_type = $(this).data("media_type")
            var mediaselect = $(this).hasClass("select")
            if (media_type == "all") {
                $(".library-type-list li").each(function () {
                    if (mediaselect) {
                        $(this).removeClass("select")
                        $(".library-list li").hide(500);
                    } else {
                        $(this).addClass("select")
                        $(".library-list li").show(500);
                    }
                })

            } else {
                if ($(this).hasClass("select")) {
                    $(this).removeClass("select")

                    $(".library-list li").each(function () {
                        if ($(this).attr("data-media_type") == media_type) {
                            console.log(media_type)
                            $(this).hide(500)

                        }
                    })
                } else {
                    $(this).addClass("select")
                    $(".library-list li").each(function () {
                        if ($(this).attr("data-media_type") == media_type) {
                            console.log(media_type)
                            $(this).show(500)
                        }
                    })
                }
            }
        })
    }
    var date_list = function () {
        $("#library-select").on("change", function () {
            var date = $(this).val();
            console.log(date)
        })
    }
    var count_list = function () {
        $("#library-count").on("change", function () {
            var count = $(this).val();
            console.log(count)
        })
    }

    var reload_list = function () {
        $('[data-media="reload"]').on("click", function (e) {
            e.preventDefault();
            var selected_date = $("#library-select").val()
            var selected_count = $("#library-count").val()
            const option = {
                component_name: "library_content",
                component_action: "load",
                component_object: {"selected_date": selected_date, "selected_count": selected_count, "selected_page_number": 1},
            }
            component_run.run(option);
        })
    }


    return {
        init: async function () {
            view_list();
            type_list();
            date_list();
            count_list();
            reload_list();

        }
    }
}()

$(document).ready(function () {
    library_content_header.init(); // init metronic core componets
});