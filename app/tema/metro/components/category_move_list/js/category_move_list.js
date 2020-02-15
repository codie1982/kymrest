var category_move_list = function () {
    var send = async function () {
        const  category_data_options = {component_name: "category_move_list", action: "getdata"}
        $.ajax({type: "post",
            url: component_controller_url(category_data_options),
            data: "",
            dataType: "json",
            beforeSend: function () {
            },
            success: function (data) {

                if (data.sonuc) {
                    let category_data = (JSON.parse(data.tree));
                    const options = {
                        core: {
                            animation: 200,
                            multiple: false,
                            themes: {"variant": "small"},
                            data: category_data
                        },
                    }

                    $("#category_move_list")
                            .on('changed.jstree', function (e, data) {
                                var i, j, r = [];
                                let selected_category_name = document.getElementById("move_list_category_name");
                                selected_category_name.innerHTML = '<d>\n\
                                                    Üst Kategori <strong>' + data.node.text + '</strong>\n\
                                                    <button data-category_main_list="remove_parent_category" class="btn btn-xs btn-danger btn-circle" style="margin-left:10px;" title="Ana Kategori Seçimini Kaldırın">\n\
                                                    <i class="fa fa-times"></i></button>\n\
                                                    <input type="hidden" name="@category_fields$parent_category_id" value="' + data.selected[0] + '" />\n\
                                                    </d>';
                                $('[data-category_move_list="remove_parent_category"]').on("click", function (e) {
                                    e.preventDefault();
                                    $(this).parents("d").hide("500", function () {
                                        $(this).remove();
                                    })
                                    let selected_category_name = document.getElementById("selected_category_name");
                                    selected_category_name.innerHTML = "";
                                })

                            }).jstree(options);
                }
            }
        });

    }


    return {
        init: function () {
            send()
        }
    }


}()

$(document).ready(function () {
    category_move_list.init(); // init metronic core componets
});
