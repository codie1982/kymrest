$.fn.topban_table = function (options) {
    var $this = this;
    var defaults = {
        html: true,
        start: 0,
        end: 10,
        show: 10,
        category: "all",
        condition: "all",
        order: "desc",
    }
    var settings = $.extend({}, defaults, options);
    sort_list()
    change_background()
    change_public()
    if (settings.html)
        addTable()

    function addTable() {
        var scriptURL = "/xhr/topban/gettopbantable";

        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "start": settings.start,
                "end": settings.end,
                "show": settings.show,
                "condition": settings.condition,
                "order": settings.order,
            },
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    $this.html(data.html)
                    $('[data-topban="remove_image"]').off();
                    $('[data-topban="remove_image"]').on("click", function (e) {
                        e.preventDefault();
                        var gallery_seccode = $(this).data("gallery_seccode");
                        var btn = $(this)
                        remove_image_item(gallery_seccode, btn)
                    })
                    sort_list()
                    change_background()
                    change_public()
                    toastr["success"](data.msg)
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    $('[data-topban="remove_image"]').on("click", function (e) {
        e.preventDefault();
        var gallery_seccode = $(this).data("gallery_seccode");
        var btn = $(this)
        remove_image_item(gallery_seccode, btn)

    })


    function remove_image_item(gallery_seccode, btn) {
        var scriptURL = "/xhr/topban/removetopbanitem";

        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "gallery_seccode": gallery_seccode,
            },
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    if (typeof btn !== "undefined") {
                        btn.parents("tr").fadeOut("500", function () {
                            $(this).remove()
                        })
                    } else {
                        $this.find('input#' + gallery_seccode).parents("tr").remove()
                    }
                    toastr["success"](data.msg)
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }

    function sort_list() {
        var table = $this.find("tbody")
        table.sortable({
            opacity: 0.5,
            delay: 250,
            update: function (event, ui) {

                var gallery_seccode = [];
                $(this).children("tr").each(function () {
                    gallery_seccode.push($(this).find('[data-gallery_seccode]').data("gallery_seccode"))

                })

                var scriptURL = "/xhr/topban/sortimage";
                $.ajax({type: "post",
                    url: scriptURL,
                    async: true,
                    cache: false,
                    data: {"gallery_seccode": gallery_seccode},
                    dataType: "json",
                    beforeSend: function () {
                        $("body").find(".waiting_screen").fadeIn()
                    },
                    success: function (data) {
                        $("body").find(".waiting_screen").fadeOut()
                        if (data.sonuc) {
                            toastr["success"](data.msg)
                        } else {
                            toastr["success"](data.msg)
                        }
                    }
                });
                console.log()
            }

        })
    } 


    function change_background() {
        $('[name="topbanner_color"]').on("change", function () {
            var gallery_seccode = $(this).data("gallery_seccode");
            var selected_color = $(this).val();
            var scriptURL = "/xhr/topban/changebackground";
            $.ajax({type: "post",
                url: scriptURL,
                data: {"gallery_seccode": gallery_seccode, "selected_color": selected_color
                },
                dataType: "json",
                beforeSend: function () {
                    $("body").find(".waiting_screen").fadeIn()
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()
                    if (data.sonuc) {
                        toastr["success"](data.msg)
                    } else {
                        toastr["error"](data.msg)
                    }
                }
            });
        })
    }

    function change_public() {
        $('[name="make_image_public"]').on("change", function () {
            var gallery_seccode = $(this).val();
            var checked_value;
            if ($(this).prop("checked")) {
                checked_value = 1
            } else {
                checked_value = 0;
            }
            var scriptURL = "/xhr/topban/changepublic";
            $.ajax({type: "post",
                url: scriptURL,
                data: {"gallery_seccode": gallery_seccode, "checked_value": checked_value
                },
                dataType: "json",
                beforeSend: function () {
                    $("body").find(".waiting_screen").fadeIn()
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()
                    if (data.sonuc) {
                        toastr["success"](data.msg)
                    } else {
                        toastr["error"](data.msg)
                    }
                }
            });
        })
    }
    return {

        removeitem: function (gallery_seccode) {
            remove_image_item(gallery_seccode)
            return $this; // Preserve the jQuery chainability 
        }

    }
}