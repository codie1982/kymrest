$.fn.category_table = function (options) {
    var $this = this;

    var defaults = {
        category_seccode: null,
    }
    var settings = $.extend({}, defaults, options);

    if (settings.category_seccode !== null) {


        addTable(settings.category_seccode)

    } else {
        alert("Kategori Bilgisi Eksik")
    }

    function addTable(category_seccode) {
        var scriptURL = "/xhr/productcategory/getcategorygallerytable";
        $.ajax({type: "post",
            url: scriptURL,
            data: {"category_seccode": category_seccode},
            dataType: "json",
            beforeSend: function () {
                $this.html('<div class="row"><div class="col-sm-12"><div class="progress"><div class="progress-bar-indeterminate"></div></div></div></div>')
            },
            success: function (data) {

                if (data.sonuc) {
                    $this.html(data.html)
                    $this.prev("#category_alert").find(".alert").html('<div class="row"><div class="col-sm-10"></div><div class="col-sm-2"><button class="btn btn-info" data-category="refresh_table"><span class="fa fa-refresh"></span> Tabloyu Kaydet</button></div></div>')
                    if (data.count > 10) {
                        $this.prev("#category_alert").find(".alert").addClass("alert-danger")
                        $this.prev("#category_alert").find(".alert").html('<div class="row"><div class="col-sm-10">Kategoride cok fazla resim bulunmaktadır. Toplam olarak ' + data.count + ' resim Bulunmaktadır</div><div class="col-sm-2"><button class="btn btn-info" data-category="remove_category_all_image">Kategoriyi Temizle</button></div></div>')
                        toastr["warning"]("Kategoride cok fazla resim bulunmaktadır")
                    } else if (data.count == 0) {
                        toastr["warning"]("Kategoride hiç resim bulunmamaktadır")
                        $this.prev("#category_alert").find(".warning").html('Kategorinize ait hiç resim bulunmamaktadır.')
                    }

                    toastr["success"](data.msg)
                    $('[data-category="select_category_thumbnail"]').off()
                    $('[data-category="select_category_thumbnail"]').on("click", function () {
                        var img = $(this)
                        var imgsource = img.attr("src")

                        var main_image_id = $(this).data("main_image_category_gallery_id");
                        var thumbnail_id = $(this).data("thumbnail_image_gallery_id");
                        var scriptURL = "/xhr/productcategory/addthumbnailimage";
                        $.ajax({type: "post",
                            url: scriptURL,
                            data: {"main_image_id": main_image_id, "thumbnail_id": thumbnail_id},
                            dataType: "json",
                            beforeSend: function () {
                                $("body").find(".waiting_screen").fadeIn()
                            },
                            success: function (data) {
                                $("body").find(".waiting_screen").fadeOut()
                                if (data.sonuc) {
                                    img.parents("td").find(".select_thumb").html('<img src="' + imgsource + '" alt="select_thumb" />')
                                    toastr["success"](data.msg)
                                } else {
                                    toastr["error"](data.msg)
                                }
                            }
                        });

                    })
                    $('[data-category="remove_category_image" ]').off()
                    $('[data-category="remove_category_image" ]').on("click", function () {
                        var category_gallery_id = $(this).data("category_gallery_id");
                        var scriptURL = "/xhr/productcategory/removecategoryimage";
                        var btn = $(this);
                        $.ajax({type: "post",
                            url: scriptURL,
                            data: {"category_gallery_id": category_gallery_id},
                            dataType: "json",
                            beforeSend: function () {
                                $("body").find(".waiting_screen").fadeIn()
                            },
                            success: function (data) {
                                $("body").find(".waiting_screen").fadeOut()
                                if (data.sonuc) {
                                    btn.parents("tr").fadeOut("500", function (e) {
                                        $(this).remove();
                                    })
                                    toastr["success"](data.msg)
                                } else {
                                    toastr["error"](data.msg)
                                }
                            }
                        });
                    })

                    $('[data-category="update_category_image" ]').off()
                    $('[data-category="update_category_image" ]').on("click", function () {
                        var category_gallery_id = $(this).data("category_gallery_id");
                        var scriptURL = "/xhr/productcategory/updatecategoryimage";
                        var btn = $(this);
                        var label = btn.parents("tr").find('[name="main_image_description"]').val()
                        var main_image = btn.parents("tr").find('[name="main_image"]').prop("checked") ? 1 : 0;
                        var image_line = btn.parents("tr").find('[name="image_line"]').children("option:selected").val()
                        var main_image_redirect = btn.parents("tr").find('[name="main_image_redirect"]').val()

                        $.ajax({type: "post",
                            url: scriptURL,
                            data: {"category_gallery_id": category_gallery_id, "label": label, "main_image": main_image, "image_line": image_line, "main_image_redirect": main_image_redirect},
                            dataType: "json",
                            beforeSend: function () {
                                $("body").find(".waiting_screen").fadeIn()
                            },
                            success: function (data) {
                                $("body").find(".waiting_screen").fadeOut()
                                if (data.sonuc) {
                                    addTable(category_seccode)
                                    toastr["success"](data.msg)
                                } else {
                                    toastr["error"](data.msg)
                                }
                            }
                        });
                    })


                    $('[data-category="remove_category_all_image"]').on("click", function () {
                        var resq = confirm("Bu Kategori altındaki Tüm resimleri ve Küçük resimleri silmek istiyormusunuz")
                        if (resq) {
                            var scriptURL = "/xhr/productcategory/removecategoryimagelist";
                            var btn = $(this);
                            $.ajax({type: "post",
                                url: scriptURL,
                                data: {"category_seccode": settings.category_seccode},
                                dataType: "json",
                                beforeSend: function () {
                                    $("body").find(".waiting_screen").fadeIn()
                                },
                                success: function (data) {
                                    $("body").find(".waiting_screen").fadeOut()

                                    if (data.sonuc) {
                                        addTable(settings.category_seccode)
                                        toastr["success"](data.msg)
                                    } else {
                                        toastr["error"](data.msg)
                                    }
                                }
                            });
                        } else {
                            toastr["success"]("Tebrikler Resimlere kıymayın:)))");
                        }

                    })

                    $('[data-category="refresh_table"]').on("click", function () {
                        $("body").find(".waiting_screen").fadeIn()
                        $this.find("tbody tr").each(function () {
                            var category_gallery_id = $(this).find('[name="category_gallery_id"]').val()
                            var label = $(this).find('[name="main_image_description"]').val()
                            var main_image = $(this).find('[name="main_image"]').prop("checked") ? 1 : 0;
                            var image_line = $(this).find('[name="image_line"]').children("option:selected").val()
                            var scriptURL = "/xhr/productcategory/updatecategoryimage";
                            $.ajax({type: "post",
                                url: scriptURL,
                                data: {"category_gallery_id": category_gallery_id, "label": label, "main_image": main_image, "image_line": image_line},
                                dataType: "json",
                                beforeSend: function () {

                                },
                                success: function (data) {

                                    if (data.sonuc) {

                                        toastr["success"](data.msg)
                                    } else {
                                        toastr["error"](data.msg)
                                    }
                                }
                            });
                            $("body").find(".waiting_screen").fadeOut()
                            addTable(category_seccode)
                        })
                    })


                    $('[data-category="add_main_slider"]').on("change", function () {
                        console.log($(this))
                        var category_gallery_id = $(this).data("category_gallery_id");
                        if ($(this).prop("checked")) {
                            var scriptURL = "/xhr/productcategory/addimagemainslider";
                        } else {
                            var scriptURL = "/xhr/productcategory/removeimagemainslider";
                        }

                        $.ajax({type: "post",
                            url: scriptURL,
                            async: true,
                            cache: false,
                            data: {"category_gallery_id": category_gallery_id},
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
                    })





                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }

}