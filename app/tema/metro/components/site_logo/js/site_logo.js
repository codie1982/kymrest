var site_logo = function () {
    return {
        init: async function () {
            const options = {
                form_type: "sitelogo",
                image_file_types: ["image/jpeg", "image/jpg", "image/gif", "image/png"],
                image_re_resolution: [500, 250, 100, 50],
                image_count: 1,
                total_image_count: 1,
                image_max_size: 15,
                title: "Siteniz için bir 570 x 220 (px) ölçülerinde logo ekleyiniz..",
                input_title: "Logo Ekleyin Seçin",
                helper_text: "Siteniz için resim yükleyiniz",
                loading_text: "Yükleniyor...",
                multiple: false,
                images_load: function () {

                    var url = window.location.href;
                    var a = document.createElement('a');
                    a.href = url;
                    var hostname = "http://" + a.hostname + "/";
                    let images_info = this, img_souce, content = "";
                    for (var i = 0; i < Object.keys(images_info).length; i++) {
                        img_souce = images_info[i].relative_path + images_info[i].first_image_name + "_ORJ." + images_info[i].extention
                        content += ' <input class="image_gallery_id" type="hidden" name="@settings_general_fields$image_gallery_id" value="' + images_info[i].image_gallery_id + '" />'
                        content += ' <img class="img-responsive img-thumbnail" width="150"src="/' + img_souce + '" alt="product_gallery_image"/>'
                    }

                    var output = $("#site_logo_output");
                    output.html(content)

                }
            }

            $("#sitelogo").image_upload(options);
        }
    }
}()

$(document).ready(function () {
    site_logo.init(); // init metronic core componets
});