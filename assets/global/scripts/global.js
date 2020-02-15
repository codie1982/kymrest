/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var global = function () {
    var pathname = window.location.pathname; // Returns path only

    var url = window.location.href;
    var a = document.createElement('a');
    a.href = url;
    var hostname = "http://" + a.hostname + "/";


    function formatState(repo) {
        console.log(repo);
        if (!repo.id) {
            return repo.text;
        }
        var $state = $('<span>' + repo.full_name + '</span>');
        return $state;
    }

    function formatRepoSelection(repo) {
        return repo.full_name || repo.text;
    }
    function formatRepo(repo) {
        console.log(repo)
        if (repo.loading)
            return repo.text;
        var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__avatar'></div>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";
        if (repo.description) {
            markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
        }

        markup += "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks'><span class='glyphicon glyphicon-flash'></span> " + repo.forks_count + " Forks</div>" +
                "<div class='select2-result-repository__stargazers'><span class='glyphicon glyphicon-star'></span> " + repo.stargazers_count + " Stars</div>" +
                "<div class='select2-result-repository__watchers'><span class='glyphicon glyphicon-eye-open'></span> " + repo.watchers_count + " Watchers</div>" +
                "</div>" +
                "</div></div>";
        return markup;
    }
    function isFunction(functionToCheck) {
        return functionToCheck && {}.toString.call(functionToCheck) === '[object Function]';
    }



    var handleimageUpload = function () {

        $('[data-image___input]').on("change", function () {
            var form_type = $(this).data("input_form_type"),
                    image_file_types,
                    image_max_count,
                    image_max_size,
                    image_count = this.files.length,
                    image_length,
                    total_image,
                    result_image,
                    i,
                    send_file = true,
                    image_form = $(this).parents('[data-image_form="' + form_type + '"]').find('[data-form="image_form"]'),
                    output = $(this).data("output")

            if (form_type == "site_logo") {
                image_file_types = ["image/jpeg", "image/jpg", "image/gif", "image/png"]; // geçerli dosya tipleri
                image_max_count = 1;
                image_max_size = 5;
            } else if (form_type == "category_gallery_form") {
                image_file_types = ["image/jpeg", "image/jpg", "image/gif", "image/png"]; // geçerli dosya tipleri
                image_max_count = 50;
                image_max_size = 15;
            } else if (form_type == "product_gallery_form") {
                image_file_types = ["image/jpeg", "image/jpg", "image/gif", "image/png"]; // geçerli dosya tipleri
                image_max_count = 6;
                image_max_size = 15;
                total_image = $("#" + output).find("img").length
            } else if (form_type == "middelslider_gallery") {
                image_file_types = ["image/jpeg", "image/jpg", "image/gif", "image/png"]; // geçerli dosya tipleri
                image_max_count = 20;
                image_max_size = 20;
            } else if (form_type == "topban_form") {
                image_file_types = ["image/jpeg", "image/jpg", "image/gif", "image/png"]; // geçerli dosya tipleri
                image_max_count = 0;
                image_max_size = 20;

            }
            if (image_max_count != 0)
                if (image_count > image_max_count) {
                    alert('En fazla ' + image_max_count + ' adet resim seçebilirsiniz.');
                    send_file = false;
                }

            if (image_max_count == 0) {
                send_file = true;
            } else {
                if (total_image >= image_max_count) {
                    if (result_image === 0) {
                        if (image_max_count != 0) {
                            alert('Başka Resim Yükleyemezsiniz. Mevcut Resimlerden bir veya daha fazlasını kaldırarak Başka resim yükleyebilirsiniz.');
                        }

                    } else {
                        if (image_max_count != 0) {
                            alert('En fazla ' + result_image + ' tane daha resim seçebilirsiniz');
                        }

                    }
                    send_file = false;
                } else {
                    for (i = 0; i < image_count; i++) {
                        if (window.FileReader) {
                            if ($.inArray(this.files[i].type, image_file_types) == -1) {
                                alert("Sadece resim dosyası ekleyebilirsiniz!");
                                send_file = false;
                                return;
                            } else {
                                var filesize = this.files[i].size
                                var file_size_MB = filesize / 1024 / 1024;
                                if (file_size_MB >= image_max_size) {
                                    send_file = false;
                                    alert('Dosya Boyutları ' + image_max_size + ' MB den Büyük Olamaz');
                                    return;
                                } else {
                                    send_file = true
                                }
                            }
                        }
                    }
                }
            }

            if (send_file) {
                _send_image(image_form, form_type, output)
                return false
            } else {
                alert("Bu Dosya Yüklenemez");
                return;
            }
        })
    }

    function _send_image(image_form, form_type, output) {
        image_form.ajaxForm({
            dataType: 'json',
            beforeSubmit: function (e) {
                $("body").find(".waiting_screen").fadeIn()
                image_form.find(".uploadArea").css({"z-index": "9999"});
                image_form.find(".uploading").fadeIn();
            },
            uploadProgress: function (olay, yuklenen, toplam, yuzde) {
                image_form.find(".imageProgresWidth").animate({"width": yuzde + "%"})
                image_form.find(".loadingText").html("%" + yuzde + " " + toplam + " " + yuklenen)
            },
            success: function (data) {

                if (data.sonuc) {
                    toastr["success"](data.msg)
                    setup_image_list(image_form, data.filename, form_type)
                    if (form_type == "site_logo") {
                        //assets/tema/ks/image/site_logo/STL5c696b8d010d3
                        console.log(data.images_info);
                        setsiteLogo(data.image_seccode[0]);
                        var image_path = hostname + 'assets/tema/' + data.tema + '/image/' + data.images_info[0]["form_type"] + "/" + data.images_info[0]["uniqid"] + "/" + data.images_info[0]["first_image_name"] + '_ORJ.' + data.images_info[0]["extention"];
                        $("body").find(output).html('<img src="' + image_path + '" width="285" height="110" alt="' + data.images_info[0]["first_image_name"] + '" /><input type="hidden" name="image_gallery_seccode" value="' + data.image_seccode[0] + '" />');
                    } else if (form_type == "category_gallery_form") {
                        category_gallery_table(data.images_info, data.category_seccode, image_form, output)
                    } else if (form_type == "product_gallery_form") {
                        product_image_list(data.images_info, image_form, output)
                    } else if (form_type == "middelslider_gallery") {
                        middelslider_gallery(data.images_info, image_form, output)
                    } else if (form_type == "topban_form") {
                        topban_form_gallery(data.images_info, image_form, output)
                    }
                } else {
                    image_form.find(".loadingText").html("Yükleme Başarısız");
                    toastr["danger"](data.msg)

                }


                image_form.find(".uploading").fadeOut();
                image_form.find(".uploadArea").css({"z-index": "-1"});
                $("body").find(".waiting_screen").fadeOut()

            }, complete: function (data) {

            }, error: function (data) {
                image_form.find(".loadingText").html("Yükleme Başarısız. Lütfen Tekrar Deneyin");
                image_form.find(".uploading").fadeOut();
                image_form.find(".uploadArea").css({"z-index": "-1"});
                $("body").find(".waiting_screen").fadeOut()
                toastr["error"](data.msg)
            },
            timeout: 9000000
        }).submit();
    }
    function setsiteLogo(images_seccode) {
        //SET İşlemi ile DB ye yazmamız gerekiyor
        var scriptURL = "/xhr/settings/setsiteLogo";
        $.ajax({type: "post",
            url: scriptURL,
            data: {"images_seccode": images_seccode},
            dataType: "json",
            beforeSend: function () {
            },
            success: function (data) {
                image_form.find(".loadingText").html("Resim Dosyaları Düzenleniyor")
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim
                    $('#' + output).topban_table()
                } else {
                    toastr["error"](data.msg)
                }
            }
        });

    }
    function topban_form_gallery(images_info, image_form, output) {
        //SET İşlemi ile DB ye yazmamız gerekiyor
        var scriptURL = "/xhr/topban/settopbangallery";
        $.ajax({type: "post",
            url: scriptURL,
            data: {"images_info": images_info},
            dataType: "json",
            beforeSend: function () {
            },
            success: function (data) {
                image_form.find(".loadingText").html("Resim Dosyaları Düzenleniyor")
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim
                    $('#' + output).topban_table()
                } else {
                    toastr["error"](data.msg)
                }
            }
        });

    }
    function middelslider_gallery(images_info, image_form, output) {
        //SET İşlemi ile DB ye yazmamız gerekiyor
        var scriptURL = "/xhr/middelslider/setmiddelslidergallery";
        $.ajax({type: "post",
            url: scriptURL,
            data: {"images_info": images_info},
            dataType: "json",
            beforeSend: function () {
            },
            success: function (data) {
                image_form.find(".loadingText").html("Resim Dosyaları Düzenleniyor")
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim

                    $('#' + output).middel_slider_table()
                } else {
                    toastr["error"](data.msg)
                }
            }
        });

    }


    function product_image_list(images_info, image_form, output) {
        var image_count = images_info.length;
        var img_souce;
        var image_line = "";
        var first_image;
        var i = 0;
        var content = '<ul class="sortable">';
        for (i = 0; i < image_count; i++) {
            //image/category_gallery_form/EXC5c6c62bcf1751/201902192310361978022014_ORJ.jpg';

            img_souce = '/assets/tema/ks/image/product_gallery_form/' + images_info[i].uniqid + '/' + images_info[i].first_image_name + '_ORJ.' + images_info[i].extention
            content += '<li><div class="row"><div class="col-sm-8 product_image_content"><input type="hidden" name="product_gallery_image[]" value="' + images_info[i].galery_seccode + '" /><img class="img-responsive img-thumbnail" src="' + img_souce + '" alt=""/><button class="btn btn-danger btn-remove-image" data-product="remove_product_image" data-image_gallery_seccode="' + images_info[i].galery_seccode + '"><span class="fa fa-remove"></span></button></div></div></li>'
            //console.log(img_souce);
            image_line += images_info[i].galery_seccode + ","
            if (i == 0) {
                first_image = images_info[i].galery_seccode;
            }
        }
        content += '</ul>';
        $("#product_gallery_image_line").html('<input type="hidden" name="image_line" value="' + image_line + '" />')
        $("#product_gallery_first_image").html('<input type="hidden" name="first_image" value="' + first_image + '" />');

        //SET İşlemi ile DB ye yazmamız gerekiyor
        //Eklenen imageleri liste halinde buraya koyup bir ekleyelim
        //console.log(images_info);
        //console.log(content);

        $("#" + output).append(content)

        $('[data-product="remove_product_image"]').on("click", function (e) {
            e.preventDefault();
            var gallery_seccode = $(this).data("image_gallery_seccode")
            var scriptURL = "/xhr/sendproduct/remove_product_image_from_image_gallery";
            var btn = $(this)
            $.ajax({type: "post",
                url: scriptURL,
                data: {"gallery_seccode": gallery_seccode},
                dataType: "json",
                beforeSend: function () {
                    $("body").find(".waiting_screen").fadeIn()
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()
                    if (data.sonuc) {
                        toastr["success"](data.msg)
                        //Plugin haline getirelim
                        btn.parent().parent().parent().fadeOut("500", function () {
                            $(this).remove()
                        })

                    } else {
                        toastr["error"](data.msg)
                    }
                }
            });
        })

        //<div id="product_gallery_image_line"></div>
        //<div id="product_gallery_first_image"></div>

        $(".product_gallery").on("click", "img", function () {
            $(this).parents("ul").find("img").each(function () {
                $(this).css({
                    "border-color": "#ddd",
                })
            })
            $(this).css({
                "border-color": "#ec9f18",
            })
            var firstimg;
            firstimg = $(this).prev('input[name="product_gallery_image[]"]').val()
            $("#product_gallery_first_image").html('<input type="hidden" name="first_image" value="' + firstimg + '" />');
        })

        $(".sortable").sortable({
            opacity: 0.5,
            delay: 250,
            start: function (event, ui) {
                $("#event_list").html("Başladı")
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
                var image_line = 0;
                var imgline = "";
                var vla
                $("ul.sortable li").each(function () {

                    vla = $(this).find('input[name="product_gallery_image[]"]').val();
                    if (typeof vla !== "undefined") {
                        imgline += vla + ","
                    }
                })
                $("#product_gallery_image_line").html('<input type="hidden" name="image_line" value="' + imgline + '" />')
            }
        });

    }
    function category_gallery_table(images_info, category_seccode, image_form, output) {

        //SET İşlemi ile DB ye yazmamız gerekiyor
        var scriptURL = "/xhr/productcategory/setcategorygallery";
        $.ajax({type: "post",
            url: scriptURL,
            data: {"images_info": images_info, "category_seccode": category_seccode},
            dataType: "json",
            beforeSend: function () {
            },
            success: function (data) {
                image_form.find(".loadingText").html("Resim Dosyaları Düzenleniyor")
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim
                    $('#' + output).category_table({
                        "category_seccode": category_seccode
                    })
                } else {
                    toastr["error"](data.msg)
                }
            }
        });


    }
    function user_profil_form_function(filename, image_form, output, image_preview) {
        var scriptURL = "/xhr/imageupload/setprofil";
        $.ajax({type: "post",
            url: scriptURL,
            async: true,
            cache: false,
            data: {"filename": filename, "user_seccode": user_seccode},
            dataType: "json",
            beforeSend: function () {
                image_form.find(".loadingText").html("Resimler Kayıt Ediliyor.Lütfen Bekleyin Pencereyi Kapatmayın");
            },
            success: function (data) {
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    var scriptURL = "/xhr/imageupload/setimage";
                    $.ajax({type: "post",
                        url: scriptURL,
                        async: true,
                        cache: false,
                        data: {"user_seccode": user_seccode, "image_preview": image_preview},
                        dataType: "json",
                        beforeSend: function () {
                            image_form.find(".loadingText").html("Resimler Düzenleniyor.Lütfen Bekleyin Bekleyin");
                        },
                        success: function (data) {
                            if (data.sonuc) {
                                toastr["success"](data.msg)
                                output.html(data.html)
                                //Sıralanma

                                image_form.find(".uploading").fadeOut();
                                image_form.find(".uploadArea").css({"z-index": "-1"});
                                $("body").find(".waiting_screen").fadeOut()
                            } else {
                                toastr["success"](data.msg)
                                image_form.find(".uploading").fadeOut();
                                image_form.find(".uploadArea").css({"z-index": "-1"});
                                output.find("img").css({"filter": "blur(0px)"});
                                $("body").find(".waiting_screen").fadeOut()
                            }
                        }
                    });
                } else {
                    toastr["success"](data.msg)
                }
            }
        });
    }

//    function __setup_image_list(image_form, filename, form_type) {
//        var filesize;
//        if (form_type == "site_logo") {
//            filesize = ["1000", "500", "300", "250"];
//        } else if (form_type == "category_gallery_form") {
//            filesize = ["1400", "1000", "500", "300", "250", "100", "50", "25"];
//        } else if (form_type == "product_gallery_form") {
//            filesize = ["1400", "1000", "500", "300", "250", "100"];
//        } else if (form_type == "middelslider_gallery") {
//            filesize = ["1400", "1000", "500", "300", "250", "100"];
//        } else if (form_type == "topban_form") {
//            filesize = ["1400", "1000", "500"];
//        }
//
//        for (var file in filename) {
//            for (var size in filesize) {
//                var scriptURL = "/xhr/imageupload/setupimage";
//                $.ajax({type: "post",
//                    url: scriptURL,
//                    data: {"filename": filename[file], "size": filesize[size]},
//                    dataType: "json",
//                    beforeSend: function () {},
//                    success: function (data) {
//                        image_form.find(".loadingText").html("Resim Dosyaları Düzenleniyor")
//                        if (data.sonuc) {
//                            toastr["success"](data.msg)
//                        } else {
//                            toastr["error"](data.msg)
//                        }
//                    }
//                });
//            }
//        }
//
//
//    }

    var handleimagedeleting = function () {
//  $("#logo-preview").image_deleting(); 
    }

    var handleSendForm = function () {
        $('[data-form="xhr"]').off();
        $('[data-form="xhr"]').submit(function (e) {
            e.preventDefault()
            var $this = $(this);
            var url = $this.attr("action");
            $.ajax({type: "post",
                url: url,
                data: {"form_data": $this.serialize()},
                dataType: "json",
                beforeSend: function () {
                    $("body").find(".waiting_screen").fadeIn()
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()
                    if (data.sonuc) {
                        if (data.reditect) {
                            window.location.href = hostname + data.reditect
                        } else if (data.reset) {
                            switch (data.reset_form) {
                                case"product_form":
                                    $this.find('[name="product_seccode"]').remove()
                                    $this.find("#product_gallery_listing").html("")
                                    $this.find("#product_gallery_image_line").html("")
                                    $this.find("#product_gallery_first_image").html("")

                                    $this.find('[name="product_name"]').val("")
                                    $this.find('[name="product_sub_name"]').val("")
                                    $this.find('[name="product_code"]').val("")
                                    $this.find('[data-category="select_special_fields"]').each(function () {
                                        $(this).prop("checked", false);
                                    })
                                    $this.find('[data-category="special_fields_section"]').html("")
                                    $this.find('[data-category="selected_special_fields_section"]').html("")
                                    $this.find('[name="product_cost"]').val(0)
                                    $this.find('[name="product_cost_unit"]').val("---").change()
                                    $this.find('[name="product_price"]').val(0)
                                    $this.find('[name="product_price_unit"]').val("---").change()
                                    $this.find('[name="product_discount_price"]').val(0)
                                    $this.find('[name="product_discount_type"]').val("---").change()
                                    $this.find('[name="product_transport_price"]').val(0)
                                    $this.find('[name="product_transport_price_unit"]').val("---").change()
                                    $this.find("#product_total_price").html("")
                                    $this.find('[name="product_stock"]').val(0)
                                    $this.find('[name="product_description"]').summernote("reset")
                                    $this.find('[name="product_keywords"]').tagsinput('removeAll');
                                    break;
                                case"costumer_form":
                                    $this.find('[name="customer_fullname"]').val("")
                                    $this.find('[name="customer_email"]').val("")
                                    $this.find('[name="costumer_send_mail"]').prop("checked", false)
                                    $this.find('[name="customer_type"]').val("---").change()
                                    $this.find('[data-company="adres_info"]').html("")
                                    $this.find('[data-customer="phone"]').html("")
                                    $this.find('[data-customer="credicard"]').html("")
                                    $this.find('[name="customer_description"]').summernote("reset")
                                    break;
                            }

                        }
                        toastr["success"](data.msg)
                    } else {
                        toastr["error"](data.msg)
                    }
                }
            });
        })
    }


    var item_filter = function () {
        $('[data-product="remove_all_pause"]').on("click", function (e) {
            e.preventDefault();

        })

        $('[data-filter_toggle]').on("click", function () {
            var $this = $(this)
            var filter = $this.data("filter_toggle")

            $this.parents('[data-item="filter_section"]').find('[data-filter]').each(function () {
                $(this).hide()
            })
            $this.parents('[data-item="filter_section"]').find('[data-filter="' + filter + '"]').show()
        })
    }
    return {
        init: function () {
//            handleAddNewAdresBlock(); // handle adres Blok
//            handleAddNewPhoneBlock(); // handle Telefon HTML Blok
//            handleAddNewCrediCardBlock(); // handle adres Blok
//            handleSelectCustomerType(); // handle adres Blok
//            handleCompanyTaxProvince(); //Vergi Dairesi
//            handleCompanyAccountSection(); //Hesap Bilgisi
            //handleimageUpload(); //Resim Yükleme
            //handleimagedeleting(); //Yüklenen Resimleri Silme Olayları
            //handleSendForm(); //Form Gönderme Olayları
            //item_filter(); //Form Gönderme Olayları



        }
    }
}();
jQuery(document).ready(function () {
    global.init(); // init metronic core componets
});