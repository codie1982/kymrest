var grntlogo = function () {
    return {
        init: async function () {
            const options = {
                form_type: "grntlogo",
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
                images_load: function (images_info) {
                    console.log(images_info)
                    let  img_souce, content = "";
                    img_souce = images_info.image_relative_path + images_info.first_image_name + "_ORJ." + images_info.extention
                    content += ' <input class="image_gallery_id" type="hidden" name="@settings_grnt_fields$image_gallery_id" value="' + images_info.image_gallery_id + '" />'
                    content += ' <img class="img-responsive img-thumbnail" width="150"src="/' + img_souce + '" alt="product_gallery_image"/>'
                    var output = $("#site_logo_output");
                    output.html(content)

                }
            }

            $("#grntlogo").image_upload(options);
        }
    }
}()

$(document).ready(function () {
    grntlogo.init(); // init metronic core componets
});