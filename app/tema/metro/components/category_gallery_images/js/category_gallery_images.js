var category_gallery_images = function () {
    return {
        init: async function () {
            const options = {
                form_type: "category_gallery",
                image_file_types: ["image/jpeg", "image/jpg", "image/gif", "image/png"],
                image_re_resolution: [1000, 500, 250, 100, 50],
                image_count: 5,
                total_image_count: 20,
                image_max_size: 15,
                title: "Kategori Resimlerinizi ekleyin",
                input_title: "Dosya Seçin",
                helper_text: "Kategori galerinizi Yükleyin",
                loading_text: "Yükleniyor...",
                multiple: true,
                images_load: function (image_info, info) {


                    const obj = {
                        image_info: image_info,
                        dummy: info.dummy,
                    }


                    const component_run_options = {
                        component_name: "category_images_list",
                        component_action: "new_category_images_list",
                        component_object: obj
                    }
                    component_run.run(component_run_options)

                }
            }
            /* */

            $("#category_gallery_images").image_upload(options);
        }
    }
}()

$(document).ready(function () {
    category_gallery_images.init(); // init metronic core componets
});