var product_category_tree = function () {
    var categorytree = async function () {

        const  category_data_options = {component_name: "product_category_tree", action: "getdata", }
        $.ajax({type: "post",
            url: component_controller_url(category_data_options),
            data: "",
            dataType: "json",
            beforeSend: function () {
            },
            success: function (data) {

                if (data.sonuc) {

                    let category_data = (JSON.parse(data.tree));
                    //console.log(category_data)
                    let contex_menu = (JSON.parse(data.contex_menu));
                    const options = {
                        'core': {
                            "animation": 200,
                            "themes": {"variant": "large"},
                            'data': category_data
                        },
                        "checkbox": {
                            "keep_selected_style": false
                        },
                        "plugins": ["checkbox"],
                    }
                    $("#category_tree")
                            .on('changed.jstree', function (e, data) {
                                var i, j, r = [];
                                var content = "";
                                var secret_key = "";

                                for (i = 0, j = data.selected.length; i < j; i++) {
                                    secret_key = Math.round(Math.random() * 1000);
                                    content += '<input type="hidden" name="@product_category_fields$secret_number:' + secret_key + '" value="' + secret_key + '" />'
                                    r.push(data.selected[i]);
                                    content += '<input type="hidden" name="@product_category_fields$category_id:' + secret_key + '" value="' + data.selected[i] + '" />'
                                }
                                if (data.selected.length > 0) {
                               // content += '<input type="hidden" name="@product_fields$product_category" value="' + r.join(", ") + '" />'
                                $('[data-product_form="selected_category"]').html(content)
                                }else {
                                $('[data-product_form="selected_category"]').html("")
                                    
                                }

                                let selected_category = r.join(',');
                                console.log('Selected: ' + selected_category)

                                const options = {
                                    component_name: "product_group_fields",
                                    component_action: "load",
                                    component_object: {"selected_category": r},
                                }
                                component_run.run(options)

                            })
                            .jstree(options);

                }
            }
        });
    }
    var show_cateory_list = function () {
        $('[data-category_button="open_category_list"]').on("click", function (e) {
            e.preventDefault();
            var category_tree = $("#category_tree")
            if (category_tree.css("display") == "none") {
                category_tree.show()
            } else {
                category_tree.hide()
            }
        })

    }
    var remove_category = function () {
        $('[data-category_button="remove_button"]').on("click", function (e) {
            e.preventDefault();
            var $this = $(this);
            var key = $(this).attr("key");

            if (typeof key !== "undefined") {
                var data = {product_category_id: $(this).attr("key")};

                options = {
                    component_name: "product_category_tree",
                    action: "remove",
                    data: data,
                    complete: function (data) {
                        if (data.sonuc) {
                            $this.parents(".remove_button").hide("500", function () {
                                $(this).remove()
                            })

                        }
                    }
                }
                makexhr.send(options)
            } else {
                $this.parents(".remove_button").hide("500", function () {
                    $(this).remove()
                })
            }


        })
    }

    return {
        init: function () {
            categorytree()
            show_cateory_list()
            remove_category()
        }
    }

}()

$(document).ready(function () {
    product_category_tree.init(); // init metronic core componets
});
