/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var load_audio_form = function () {

    var upload = function () {
        const options = {
            media_type: "audio",
            image_file_types: ["audio/mp3", "audio/mpeg3", "audio/x-mpeg-3"],
            image_count: 5,
            total_image_count: 20,
            image_max_size: 15,
            title: "Audio Dosyanızı Ekleyin",
            input_title: "Dosya Seçin",
            helper_text: "mp3..",
            loading_text: "Yükleniyor...",
            error_files_message: "Sadece Mp3 Dosyalarından Ekleyebilirsiniz",
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

        $("#load_audios").image_upload(options);
    }
    return {
        init: function () {
            upload();
        }
    }
}();
jQuery(document).ready(function () {
    load_audio_form.init(); // init metronic core componets
});