/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var page_middelslider = function () {

    var middel_slider_table = function () {
        $('#middel-slider-gallery').middel_slider_table({html: false});
        $('[data-refresh="middel_slider_gallery_table"]').on("click", function () {
            $('#middel-slider-gallery').middel_slider_table()
        })
    }

    var remove_all = function () {
        $('[data-product="remove_all"]').on("click", function (e) {
            e.preventDefault();
            var middelslider_gallery_seccode;
            var removeProduct = confirm("Bu Resimler Gerçekten Galeriden Kaldırmak istiyormusunuz?")
            if (removeProduct) {
                $("#middel-slider-gallery").find("table tr").each(function () {
                    var checkbox = $(this).children("td").find('input[data-selected_item="checkbox"]')

                    if (checkbox.prop("checked")) {
                        middelslider_gallery_seccode = checkbox.data("middelslider_gallery_seccode");
                        console.log(middelslider_gallery_seccode);
                        $("#middel-slider-gallery").middel_slider_table().removeitem(middelslider_gallery_seccode)
                    }
                })
            } else {
                toastr["success"]("Tebrikler Resimleri Silmeyin :))")

            }

        })
    }

    return {
        init: function () {
            middel_slider_table(); // Orta Slider Tablosu
            remove_all(); // Toplu Silme
        }
    }
}();


jQuery(document).ready(function () {
    page_middelslider.init(); // init metronic core componets
});