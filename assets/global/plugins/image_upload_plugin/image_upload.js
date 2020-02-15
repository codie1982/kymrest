$.fn.image_upload = function (options) {
    var $this = this;
    var defaults = {
        form_type: "",
        media_type: "image",
        image_file_types: ["image/jpeg", "image/jpg", "image/gif", "image/png"],
        image_re_resolution: [1000, 500, 250, 100, 50],
        image_count: 0,
        total_image_count: 0,
        image_max_size: 0,
        output: "",
        title: "",
        input_title: "",
        helper_text: "",
        loading_text: "",
        multiple: false,
        error_files_message: "Sadece resim dosyası ekleyebilirsiniz",
        images_load: function (data) {},
    }
//component_name

    const formid_number = Math.round((Math.random() * 1000));
    var table = 0;
    var settings = Object.assign({}, defaults, options);
    var form = $("#" + formid_number)


    var dummy = document.querySelectorAll('[dummy_object]');
    let dummt_data = []
    for (let i = 0; i < dummy.length; i++) {
        let dt = {};
        var keys = dummy[i].getAttribute("key")
        var value = dummy[i].getAttribute("value")
        dt[keys] = value;
        dummt_data.push(dt)
    }




    set_form();
    set_upload_event();



    function set_form() {
        var form_name, multp;
        if (settings.multiple) {
            form_name = "images[]";
            multp = "multiple";
        } else {
            form_name = "images";
            multp = "";
        }
        var dmy;
        if (dummt_data.length != 0) {
            dmy = JSON.stringify(dummt_data);
        } else {
            dmy == "---";
        }

        var form_html = '<form id="' + formid_number + '" method="post"   enctype="multipart/form-data" action="/component/tema_images_setup/upload_images"  >\n\
                            <input type="hidden" name="form_type" value="' + settings.form_type + '"/>\n\
                            <input type="hidden" name="media_type" value="' + settings.media_type + '"/>\n\
                            <input type="hidden" id="uniqid" name="uniqid" value="0"/>\n\
                            <input type="hidden" id="imagecount" name="imagecount" value="0"/>\n\
                            <input type="hidden" name="multiple" value="' + settings.multiple + '"/>\n\
                            <input type="hidden" name="dummy" value="' + btoa(dmy) + '"/>\n\
                            <i class="icon-settings font-dark"></i>\n\
                            <span class="caption-subject font-dark sbold uppercase">' + settings.title + '</span>\n\
                            <div class="fileinput fileinput-new" data-provides="fileinput">\n\
                                <span class="btn red btn-circle btn-file">\n\
                                <span class="fileinput-new">' + settings.input_title + '</span>\n\
                                    <input class="images_input" type="file" data-sendimage="xhr" ' + multp + '  name="' + form_name + '" />\n\
                                </span>\n\
                                    <span class="fileinput-filename"> </span> &nbsp;<a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>\n\
                            </div>\n\
                            <input  type="submit" value="Gönder" />\n\
                            <span class="help-inline">' + settings.helper_text + '</span>\n\
                                    <div class="row">\n\
                                            <div class="col-sm-12">\n\
                                                    <div class="uploadArea">\n\
                                                            <div class="uploading" style="display:none">\n\
                                                                    <label>&nbsp;</label>\n\
                                                                    <div class="imageProgres">\n\
                                                                        <div class="imageProgresWidth"></div>\n\
                                                                    </div>\n\
                                                                <p class="loadingText">' + settings.loading_text + '</p>\n\
                                                            </div>\n\
                                                    </div>\n\
                                            </div>\n\
                                    </div>\n\
                        </form>';
        $this.html(form_html);
    }

    function set_upload_event(form) {
        $('[data-sendimage="xhr"]').on("change", function (e) {
            e.preventDefault()
            var image_file_types = settings.image_file_types,
                    total_image_count = settings.total_image_count,
                    image_max_size = settings.image_max_size,
                    send_file = true
            if (this.files.length > total_image_count) {
                alert('En fazla ' + total_image_count + ' adet resim ekleyebilirsiniz.');
                send_file = false;
            }
            for (var i = 0; i < this.files.length; i++) {
                if (window.FileReader) {
                    console.log(this.files[i].type);
                    if ($.inArray(this.files[i].type, image_file_types) == -1) {
                        alert(settings.error_files_message);
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

            if (send_file) {
                // form.submit()

            } else {
                alert("Bu Dosya Yüklenemez");
                return;
            }
        })


    }
    $this.ajaxForm({
        dataType: 'json',
        beforeSubmit: function (e) {
            console.log()
            $("body").find(".waiting_screen").fadeIn()
            $(".uploading").parents("#" + formid_number).find(".uploading").fadeIn()
            $(".uploadArea").parents("#" + formid_number).find(".uploadArea").css({"z-index": "1"});

        },
        uploadProgress: function (olay, yuklenen, toplam, yuzde) {
            $(".imageProgresWidth").parents("#" + formid_number).find(".imageProgresWidth").animate({"width": yuzde + "%"})
            var _toplam;
            if (toplam > 1024) {
                _toplam = ((toplam / 1024 / 1024))
                _toplam = _toplam.toFixed(2) + " Mb";
            } else {
                _toplam = ((toplam / 1024))
                _toplam = _toplam.toFixed(2) + " Kb";
            }
            var _yuklenen;
            if (yuklenen > 1024) {
                _yuklenen = ((yuklenen / 1024 / 1024))
                _yuklenen = _yuklenen.toFixed(2) + " Mb";
            } else {
                _yuklenen = ((yuklenen / 1024))
                _yuklenen = _yuklenen.toFixed(2) + " Kb";
            }
            $(".loadingText").parents("#" + formid_number).find(".loadingText").html("<p>% <strong>" + yuzde + "</strong> DB : <strong>" + _toplam + "</strong> YDB : <strong>" + _yuklenen + "</strong></p>")
            $(".loadingText").parents("#" + formid_number).find(".loadingText").append("Yükleme tamamlanıncaya kadar bu pencereyi kapatmayınız")
        },
        success: function (data) {
            if (data.sonuc) {
                $("#uniqid").parents("#" + formid_number).find("#uniqid").val(data.uniqid)
                $("#imagecount").parents("#" + formid_number).find("#imagecount").val(data.imagecount)

                for (var i = 0; i < data.success_message.length; i++) {
                    toastr["success"](data.success_message[i])
                }
                console.log(settings)
                if (settings.media_type == "image")
                    setup_image_list(form, data.images_info);

                if (typeof settings.images_load !== "undefined") {
                    if (settings.multiple) {
                        settings.images_load(data.images_info, data);
                    } else {
                        settings.images_load(data.images_info[0], data);
                    }

                }
                $(".uploadArea").parents("#" + formid_number).find(".uploadArea").css({"z-index": "-1"});
                $(".uploading").parents("#" + formid_number).find(".uploading").fadeOut();
                $("body").find(".waiting_screen").fadeOut()
            } else {
//                image_form.find(".loadingText").html("Yükleme Başarısız");
                for (var i = 0; i < data.error_message.length; i++) {
                    toastr["danger"](data.error_message[i])
                }
            }
        }, complete: function (data) {

        }, error: function (data) {
            $("body").find(".waiting_screen").fadeOut()
            toastr["error"](data.msg)
        },
        timeout: 9000000
    });


    async function setup_image_list(image_form, images_info) {
        for (var i = 0; i < images_info.length; i++) {
            for (var j = 0; j < settings.image_re_resolution.length; j++) {
                new Promise(function () {
                    sendAjax(image_form, images_info[i], settings.image_re_resolution[j]);
                });

            }
        }

    }
    function sendAjax(image_form, info, resolutaion) {
        const  options = {component_name: "tema_images_setup", action: "reResulotion"}
        var scriptURL = component_controller_url(options);
        $.ajax({type: "post",
            url: scriptURL,
            data: {image_info: info, resulotion_size: resolutaion},
            dataType: "json",
            beforeSend: function () {},
            success: function (data) {
                image_form.find(".loadingText").html("Resim Dosyaları Düzenleniyor")
                if (data.sonuc) {
                    toastr["success"](data.msg)
                } else {
                    toastr["error"](data.msg)
                }
                return data;
            }
        });
    }
}