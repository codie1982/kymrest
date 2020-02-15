var library_content = function () {
    var library_list = function () {
        $(".select-box").on("click", function (e) {
            //e.preventDefault();
            if ($(this).parents("li").hasClass("select")) {
                $(this).parents("li").removeClass("select")
            } else {
                $(this).parents("li").addClass("select")
            }

        })
    }
    var fancy = function () {
        $('[data-fancybox="gallery"]').fancybox();
    }
    var library_filter = function () {
        $(".library_filter").on("click", function (e) {
            e.preventDefault();

            $(".library_filter").each(function () {
                $(this).removeClass("active")
            })
            $(this).addClass("active")

            var filter_type = $(this).children("input").data("media")
            if (filter_type == "all_media") {
                $(".library-list li:visible").addClass("select")
            } else if (filter_type == "break_all_media") {
                $(".library-list li:visible").removeClass("select")
            } else if (filter_type == "no_media") {
                $(".library-list li:visible").each(function () {
                    if ($(this).data("filter") == "no_media") {
                        $(this).addClass("select")
                    }
                })
            } else if (filter_type == "no_db") {
                $(".library-list li:visible").each(function () {
                    if ($(this).data("filter") == "no_db") {
                        $(this).addClass("select")
                    }
                })
            }

        })
    }
    var remove_selected = function () {
        $('[data-media="remove_selected"]').on("click", function (e) {
            e.preventDefault();
            const idlist = [];
            $(".library-list li.select:visible").each(function () {
                var imageid = $(this).data("image_gallery_id")
                idlist.push(imageid)
            })
            if (idlist.length != 0) {
                var rm = confirm("Medya dosyalarınızın sistemden kaldırmak üzeresiniz. Dosyalarınız geri dönüşü olmaz bir şekilde sistemden kaldırılacaktır. Bunu yapmak istediğinizden eminmisiniz?")
                if (rm) {
//                    const option = {
//                        component_name: "library_content",
//                        component_action: "remove",
//                        component_object: {"gallery_image_id": idlist},
//                    }
//                    component_run.run(option);

                    options = {
                        component_name: "library_content",
                        action: "remove",
                        data: {"gallery_image_id": idlist},
                        complete: function (data) {
                            const option = {
                                component_name: "library_content",
                                component_action: "load",
                                component_object: {"selected_date": "all", "selected_count": 10, "selected_page_number": 1},
                            }
                            component_run.run(option);
                        }
                    }
                    makexhr.send(options)
                }
            } else {
                alert("Öncelikle Dosyalarınızdan bir veya birkaçını seçmeniz gerekmektedir")
            }
        })
    }
    var pagination = function () {
        $(".library-pagination-page-button").on("click", function () {
            $(".library-pagination-page-button").each(function () {
                $(this).removeClass("select")
            })
            $(this).addClass("select")
        })
    }
    return {
        init: async function () {
            library_list();
            fancy();
            library_filter();
            remove_selected();
            pagination();
        }
    }
}()

$(document).ready(function () {
    library_content.init(); // init metronic core componets
});