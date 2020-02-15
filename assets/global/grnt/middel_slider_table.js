$.fn.middel_slider_table = function (options) {
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
    addSlider()
    updateSliderLink()
    if (settings.html)
        addTable()

    function addTable() {
        var scriptURL = "/xhr/middelslider/getmiddelslidertable";
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
                    sort_list()
                    addSlider()
                    updateSliderLink()
                    $('[data-middelslider="remove_middelslider_image"]').off();
                    $('[data-middelslider="remove_middelslider_image"]').on("click", function (e) {
                        e.preventDefault();
                        var btn = $(this)
                        var middelslider_gallery_seccode = btn.data("middelslider_gallery_seccode");
                        remove_image_item(middelslider_gallery_seccode, btn)
                    })
                    toastr["success"](data.msg)
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    $('[data-middelslider="remove_middelslider_image"]').on("click", function (e) {
        e.preventDefault();
        var middelslider_gallery_seccode = $(this).data("middelslider_gallery_seccode");
        var btn = $(this)
        remove_image_item(middelslider_gallery_seccode, btn)

    })

    function sort_list() {
        var table = $this.find("tbody")
        table.sortable({
            opacity: 0.5,
            delay: 250,
            update: function (event, ui) {

                var gallery_seccode = [];
                $(this).children("tr").each(function () {
                    gallery_seccode.push($(this).find('[data-middelslider_gallery_seccode]').data("middelslider_gallery_seccode"))

                })

                var scriptURL = "/xhr/middelslider/sortimage";
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


    function addSlider() {
        $('[name="add_slider_item"]').on("change", function () {
            var gallery_seccode = $(this).val();
            var checked_value;
            if ($(this).prop("checked")) {
                checked_value = 1
            } else {
                checked_value = 0;
            }
            var scriptURL = "/xhr/middelslider/changepublic";
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

    function updateSliderLink() {

        $('[data-slider="update_link"]').on("click", function (e) {
            e.preventDefault();
            var gallery_seccode = $(this).data("gallery_seccode");
            var url_value = $(this).parents(".slider_link").find('[name="slider_image_link"]').val();
            if (url_value != "---") {
                if (url_value.trim() !== "") {
                    var scriptURL = "/xhr/middelslider/updatesliderlink";
                    $.ajax({type: "post",
                        url: scriptURL,
                        data: {"gallery_seccode": gallery_seccode, "url_value": url_value
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
                } else {
                    toastr["error"]("Boş Alan Bırakmayınız.")
                }
            } else {
                toastr["error"]("Geçerli bir url değeri giriniz.")
            }

        })
    }

    function remove_image_item(middelslider_gallery_seccode, btn) {
        var scriptURL = "/xhr/middelslider/removemiddelslideritem";

        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "middelslider_gallery_seccode": middelslider_gallery_seccode,
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
                        $this.find('input#' + middelslider_gallery_seccode).parents("tr").remove()
                    }

                    toastr["success"](data.msg)
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    return {

        removeitem: function (slider_gallery_seccode) {
            remove_image_item(slider_gallery_seccode)
            return $this; // Preserve the jQuery chainability 
        }

    }
}