/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var category_form = function () {
    var taginput = function () {
        $('[data-role="tagsinput"]').tagsinput();
    }
    return {
        init: function () {
            taginput(); // handle adres Blok

        }
    }
}();
jQuery(document).ready(function () {
    category_form.init(); // init metronic core componets
});