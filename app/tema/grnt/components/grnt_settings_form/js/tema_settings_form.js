/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var tema_settings_form = function () {
    var handleSummernote = function () {
        $('#summernote').summernote(
                {
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']]
                    ],
                    height: 200,
                    onfocus: function (e) {
                        $('body').addClass('overlay-disabled');
                    },
                    onblur: function (e) {
                        $('body').removeClass('overlay-disabled');
                    }
                });
    }

    return {
        init: function () {
            handleSummernote();
        }
    }
}();
jQuery(document).ready(function () {
    tema_settings_form.init(); // init metronic core componets
});