var category_tree = function () {
    var tree = function () {

        /*
         * 
         * 'data': [
         {"id": "ajson1", "parent": "#", "text": "Simple root node"},
         {"id": "ajson2", "parent": "#", "text": "Root node 2"},
         {"id": "ajson3", "parent": "ajson2", "text": "Child 1"},
         {"id": "ajson4", "parent": "ajson2", "text": "Child 2"},
         ]
         */

        /*
         * 
         * {
         id          : "string" // will be autogenerated if omitted
         text        : "string" // node text
         icon        : "string" // string for custom
         state       : {
         opened    : boolean  // is the node open
         disabled  : boolean  // is the node disabled
         selected  : boolean  // is the node selected
         },
         children    : []  // array of strings or objects
         li_attr     : {}  // attributes for the generated LI node
         a_attr      : {}  // attributes for the generated A node
         }
         * */


//            category_data.push({"id": "ajson1", "parent": "#", "text": "Simple root node"});
//            category_data.push({"id": "ajson2", "parent": "#", "text": "Root node 2"});
//            category_data.push({"id": "ajson3", "parent": "ajson2", "text": "Child 1"});
//            category_data.push({"id": "ajson4", "parent": "ajson2", "text": "Child 2"});

        const  category_data_options = {component_name: "category_tree_list", action: "getdata"}
        $.ajax({type: "post",
            url: component_controller_url(category_data_options),
            data: "",
            dataType: "json",
            beforeSend: function () {
            },
            success: function (data) {

                if (data.sonuc) {
                    let category_data = (JSON.parse(data.tree));
                    let contex_menu = (JSON.parse(data.contex_menu));
                    const options = {
                        core: {
                            animation: 200,
                            multiple: true,
                            themes: {"variant": "large"},
                            data: category_data
                        },
                        plugins: ["contextmenu"],
                        contextmenu: {
                            select_node: true,
                            show_at_node: true,
                            items: function (o, cb) { // Could be an object directly
                                let items = {};
                                let item;
                                for (let i = 0; i < contex_menu.length; i++) {
                                    item = {
                                        "separator_before": contex_menu[i].separator_before,
                                        "separator_after": contex_menu[i].separator_after,
                                        "_disabled": contex_menu[i]._disabled, //(this.check("create_node", data.reference, {}, "last")),
                                        "label": contex_menu[i].label,
                                        "action": function (data) {
                                            let selected_category_name = document.getElementById("selected_category_name").value
                                            let selected_category_id = document.getElementById("selected_category_id").value
                                            const object = {
                                                category_name: selected_category_name,
                                                category_id: selected_category_id,
                                            }
                                            send_data(contex_menu[i].component_name, contex_menu[i].component_action, object, contex_menu[i].modal, contex_menu[i].starter)
                                        }
                                    }
                                    let menu_name = contex_menu[i].menu_name;
                                    items[menu_name] = item;
                                }
                                return items;
                            }
                        }
                    }

                    $("#category_tree")
                            .on('changed.jstree', function (e, data) {
                                var i, j, r = [];
                                //console.log(data);
                                for (i = 0, j = data.selected.length; i < j; i++) {
                                    //console.log(data.instance.get_node(data.selected[i]));
                                    // console.log('Selected: ' + data.selected[i])
                                    //r.push(data.instance.get_node(data.selected[i]).text);
                                    r.push(data.selected[i]);
                                }
                                let selected_category_id = document.getElementById("selected_category_id");
                                let selected_category_name = document.getElementById("selected_category_name");
                                selected_category_id.value = r.join(',');
                                selected_category_name.value = data.node.text;
                                //console.log('Selected: ' + r.join(','))
                            }).jstree(options);
                }
            }
        });
    }
    //data-category_tree_list="refresh"

    return {
        init: async function () {
            tree();

        }
    }
    function send_data(component_name, component_action, component_object, modal, starter) {
        //console.log(component_action)
        const options = {
            component_name: component_name,
            component_action: component_action,
            component_object: component_object,

        }
        if (typeof modal !== "undefined") {
            options.modal = modal;
        }
        if (typeof starter !== "undefined") {
            options.starter = starter;
        }

        component_run.run(options)

    }
}()

$(document).ready(function () {
    category_tree.init(); // init metronic core componets
});
