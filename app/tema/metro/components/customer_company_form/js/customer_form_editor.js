var customer_form_editor = function () {
    var handleWysihtml5 = function () {
        if (!jQuery().wysihtml5) {
            return;
        }
        if ($('.wysihtml5').size() > 0) {
            $('.wysihtml5').wysihtml5({
                "stylesheets": ["../assets/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
            });
        }
    }
    var handleSummernote = function () {
        $('#summernote').summernote(
                {
                    toolbar: [
                        // [groupName, [list of button]]
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
        //main function to initiate the module
        init: function () {
            handleWysihtml5();
            handleSummernote();
        }
    };
}();
jQuery(document).ready(function () {
    customer_form_editor.init();
});