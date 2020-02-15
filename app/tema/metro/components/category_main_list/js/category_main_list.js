var category_main_list = function () {
    var send = async function () {
        const  category_data_options = {component_name: "category_main_list", action: "getdata"}
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

                    $("#category_main_list")
                            .on('changed.jstree', function (e, data) {
                                var i, j, r = [];
                                for (i = 0, j = data.selected.length; i < j; i++) {
                                    //console.log(data.instance.get_node(data.selected[i]));
                                    // console.log('Selected: ' + data.selected[i])
                                    //r.push(data.instance.get_node(data.selected[i]).text);
                                    r.push(data.selected[i]);
                                }
                                let selected_category = document.getElementById("mainlist_category_main_id");
                                let selected_category_name = document.getElementById("mainlist_category_name");

                                selected_category.value = r.join(',');
                                selected_category_name.innerHTML = '<d>Üst Kategori "<strong>' + data.node.text + '</strong>"<button data-category_main_list="remove_parent_category" class="btn btn-xs btn-danger btn-circle" style="margin-left:10px;" title="Ana Kategori Seçimini Kaldırın"><i class="fa fa-times"></i></button></d>';
                                //    console.log('Selected: ' + r.join(','))
                                $('[data-category_main_list="remove_parent_category"]').on("click", function (e) {
                                    e.preventDefault();
                                    $(this).parents("d").hide("500", function () {
                                        $(this).remove();
                                    })
                                    let selected_category = document.getElementById("mainlist_category_main_id");
                                    selected_category.value = 0;
                                })

                            }).jstree(options);
                }
            }
        });

    }

    var remove_selected_category = function () {
        $('[data-category_main_list="remove_parent_category"]').on("click", function (e) {
            e.preventDefault();
            $(this).parents("d").hide("500", function () {
                $(this).remove();
            })
            let selected_category = document.getElementById("mainlist_category_main_id");
            selected_category.value = 0;
        })
    }


    return {
        init: function () {
            send()
            remove_selected_category()
        }
    }


}()

$(document).ready(function () {
    category_main_list.init(); // init metronic core componets
});
