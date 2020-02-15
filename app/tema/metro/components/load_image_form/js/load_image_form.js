/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var load_image_form = function () {

    var upload = function () {
        const options = {
            media_type: "image",
            image_file_types: ["image/jpeg", "image/jpg", "image/gif", "image/png"],
            image_re_resolution: [1000, 500, 300, 100, 50],
            image_count: 5,
            total_image_count: 20,
            image_max_size: 15,
            title: "Resimlerinizi Ekleyin",
            input_title: "Dosya Seçin",
            helper_text: "Kütüphanenize Resim Ekleyin",
            loading_text: "Yükleniyor...",
            multiple: true,
            images_load: function (data) {

                const component_run_options = {
                    component_name: "library_content",
                    component_action: "load",
                    component_object: {"selected_date": "today", "selected_count": 10, "selected_page_number": 1},
                }
                component_run.run(component_run_options)

            }
        }
        /* */

        $("#load_images").image_upload(options);
    }
    return {
        init: function () {
            upload();
        }
    }
}();
jQuery(document).ready(function () {
    load_image_form.init(); // init metronic core componets
});