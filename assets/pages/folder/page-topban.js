/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var page_topban = function () {

    var topbanner_table = function () {
        $('#topban_table').topban_table({html: false});
        $('[data-refresh="topban_table"]').on("click", function () {
            $('#topban_table').topban_table()
        })
    }
    //topbanner_color
    
 

    var remove_all = function () {
        $('[data-product="remove_all"]').on("click", function (e) {
            e.preventDefault();
            var gallery_seccode;
            var removeProduct = confirm("Bu Bannerları Gerçekten Kaldırmak istiyormusunuz?")
            if (removeProduct) {
                $("#topban_table").find("table tr").each(function () {
                    var checkbox = $(this).children("td").find('input[data-selected_item="checkbox"]')

                    if (checkbox.prop("checked")) {
                        gallery_seccode = checkbox.data("gallery_seccode");

                        $('#topban_table').topban_table().removeitem(gallery_seccode)
                    }
                })
            } else {
                toastr["success"]("Tebrikler Resimleri Silmeyin :))")

            }

        })
    }





    return {
        init: function () {
            topbanner_table(); // Orta Slider Tablosu
            remove_all(); // Toplu Silme
            
        }
    }
}();


jQuery(document).ready(function () {
    page_topban.init(); // init metronic core componets
});