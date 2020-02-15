var product_images = function () {
    return {
        init: async function () {
            const options = {
                media_type: "image",
                image_file_types: ["image/jpeg", "image/jpg", "image/gif", "image/png"],
                image_re_resolution: [1000, 500, 250, 100, 50],
                image_count: 5,
                total_image_count: 20,
                image_max_size: 15,
                title: "Ürün Resimleri Ekleyin",
                input_title: "Dosya Seçin",
                helper_text: "ürününüz için resim yükleyiniz",
                loading_text: "Yükleniyor...",
                multiple: true,
                images_load: function (data) {

                    const component_run_options = {
                        component_name: "product_images_list",
                        component_action: "new_product_image_list",
                        component_key: "image_info",
                        component_data: data,
                    }
                    component_run.run(component_run_options)

                }
            }
            /* */

            $("#product_images").image_upload(options);
        }
    }
}()

$(document).ready(function () {
    product_images.init(); // init metronic core componets
});