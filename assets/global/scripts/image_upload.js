async function sendimage(image_form, form_type, output) {
    var url = window.location.href;
    var a = document.createElement('a');
    a.href = url;
    var hostname = "http://" + a.hostname;

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

$('[data-sendimage="xhr"]').on("change", function () {
    var form_type = $(this).data("input_form_type"),
            image_file_types_s = $(this).data("image_file_types"),
            image_count = $(this).data("image_count"),
            total_image_count = $(this).data("total_image_count"),
            image_max_size = $(this).data("image_max_size"),
            send_file = true,
            form_name = $(this).data("form_name"),
            form =$(form_name),
            component_name = $(this).data("component_name"),
            action = $(this).data("action"),
            output = $(this).data("image_outputid")

    console.log(form);
    var rtotal_image_count = $("#" + output).find("img");
    var select_image = this.files.length
    var image_file_types = image_file_types_s.split(",")


    const  options = {
        component_name: component_name,
        action: action,

    }
    form.prop("action", component_controller_url(options))
    if (rtotal_image_count > total_image_count) {
        alert('En fazla ' + total_image_count + ' adet resim ekleyebilirsiniz.');
        send_file = false;
    }


    if (select_image > image_count) {
        alert('En fazla ' + image_count + ' adet resim seçebilirsiniz.');
        send_file = false;
    }
    var result_image = parseInt(rtotal_image_count) - parseInt(image_count);
console.log(result_image)
//    if (total_image_count >= image_count) {
//        if (result_image === 0) {
//            alert('Başka Resim Yükleyemezsiniz. Mevcut Resimlerden bir veya daha fazlasını kaldırarak Başka resim yükleyebilirsiniz.');
//        } else {
//            if (image_count != 0) {
//                alert('En fazla ' + result_image + ' tane daha resim seçebilirsiniz');
//            }
//
//        }
//        send_file = false;
//    }
    for (var i = 0; i < select_image; i++) {
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

    if (send_file) {
        let $this = $(this)

        if ($this.data("component_name") === "" || typeof $this.data("component_name") === "undefined") {
            if ($this.data("action") === "" || typeof $this.data("action") === "undefined") {
                console.error("Form Bilginiz içersinde 'action' bilgisi bulunmamaktadır. data-action=\"fonksiyon ismi\" şeklinde ekleyiniz");
            } else {
                console.error("Form Bilginiz içersinde 'component_name' alanı bulunmamaktadır. data-component_name=\"Component İsmi\" şeklinde ekleyiniz");
            }
        } else {
            sendimage(image_form, form_type, output)
        }
        return false
    } else {
        alert("Bu Dosya Yüklenemez");
        return;
    }
})

$('[data-sendimage="xhr"]').on("change", function (e) {
    e.preventDefault();
    let $this = $(this)
//    console.log($this.data("component_name"))
//    console.log($this.data("action"))





})
