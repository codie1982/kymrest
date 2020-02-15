var gallery_images = function () {
    return {
        init: async function () {
            const options = {
                form_type: "mobile_slider_gallery_images",
                image_file_types: ["image/jpeg", "image/jpg", "image/gif", "image/png"],
                image_re_resolution: [500, 250, 100, 50],
                image_count: 5,
                total_image_count: 5,
                image_max_size: 5,
                title: "Mobil Aplikasyon için Slider Resimleriniz",
                input_title: "Dosya Seçin",
                helper_text: "Slider  Yükleyin",
                loading_text: "Yükleniyor...",
                multiple: true,
                images_load: function (image_info, info) {

                    console.log(image_info)
                    console.log(info)
                    const obj = {
                        image_info: image_info,
                        dummy: info.dummy,
                    }


                    const component_run_options = {
                        component_name: "slider_images_list",
                        component_action: "new_slider_images_list",
                        component_object: obj
                    }
                    component_run.run(component_run_options)

                }
            }
            /* */

            $("#gallery_images").image_upload(options);
        }
    }
}()

$(document).ready(function () {
    gallery_images.init(); // init metronic core componets
});