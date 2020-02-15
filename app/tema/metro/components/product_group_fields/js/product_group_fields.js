var product_group_fields = function () {
    var selected = function () {
        $('[data-product_group_color_value]').on("click", function () {
            var selected_value = $(this).data("key")
            console.log(selected_value)
            var selected_color_section = $("#selected_product_group_color_value"), add = true;

            if ($(this).hasClass("box_selected")) {
                selected_color_section.find("input").each(function (e) {
                    if ($(this).val() == selected_value) {
                        $(this).remove()
                    }
                })
                $(this).removeClass("box_selected")
            } else {
                selected_color_section.find("input").each(function (e) {
                    if ($(this).val() == selected_value) {
                        add = false;
                    }
                })
                if (add) {
                    let rand = Math.round(Math.random() * 1000);
                    selected_color_section.append(`
                    <input type="hidden" name="@product_group_fields_value$secret_number:${rand}" value="${rand}"/>
                    <input type="hidden" value="${selected_value}" name="@product_group_fields_value$value_id:${rand}" />
                        `)
                }
                $(this).addClass("box_selected")
            }
        })
    }
    return {
        init: function () {
            selected();
        }
    }
}()

$(document).ready(function () {
    product_group_fields.init(); // init metronic core componets
});
