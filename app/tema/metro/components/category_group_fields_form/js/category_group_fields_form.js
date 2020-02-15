/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var category_group_fields_form = function () {
    var remove = function () {
        $('[data-category_group_fields_form="remove"]').on("click", function (e) {
            e.preventDefault();
            var $this = $(this);
            var key = $this.data("key")
            if (typeof key !== "undefined") {
                options = {
                    component_name: "category_group_fields_form",
                    action: "remove",
                    data: {group_fields_id: key},
                    complete: function (data) {
                        if (data.sonuc) {
                            $this.parents(".form-group").fadeOut(500, function () {
                                $(this).remove();
                            })
                        }
                    }
                }
                makexhr.send(options)
            }
        })
    }
    return {
        init: function () {
            remove();
        }
    }
}();
jQuery(document).ready(function () {
    category_group_fields_form.init(); // init metronic core componets
});