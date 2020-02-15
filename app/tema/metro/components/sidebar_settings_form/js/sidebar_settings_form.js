var sidebar_settings_form = function () {
    var module_form = function () {
        let options = {
            component_name: "sidebar_settings_form",
            secret_number: true,
            formGroup: false,
            list: true,
            liclass: "mt-1",
            templateStyle: [
                {
                    parameter: "background",
                    value: "#fff",

                },
                {
                    parameter: "margin-bottom",
                    value: "10px",

                }
            ],
            rowClass: "mt-1 ",
            content: [],
            form_complete: function () {
                $("ul.sidebar_form_list").sortable({
                    opacity: 0.5,
                    delay: 250,
                    start: function (event, ui) {
                    },
                    stop: function (event, ui) {
                    },
                    sort: function (event, ui) {
                    },
                    activate: function (event, ui) {
                    },
                    update: function (event, ui) {
                        count = 1;
//                        $("ul.sortable_price_options li").each(function () {
//                            $(this).find('input.options_line').val(count);
//                            count++;
//                        })
                    }
                });
            }
        };

        var predata = document.querySelectorAll('[data-sidebar_settings_form]');
        if (predata.length !== 0) {
            for (let i = 0; i < predata.length; i++) {
                options.content = (JSON.parse(atob(predata[i].getAttribute("data-json"))));
            }
        } else {
            var predata = document.querySelector('[reset-sidebar_settings_form]');
            options.content = (JSON.parse(atob(predata.getAttribute("data-json"))));
        }
        $("ul.sidebar_form_list").makeForm(options);



        var additem = document.querySelector('[data-sidebar="add_item"]');
        additem.addEventListener("click", function (e) {
            e.preventDefault();


            var backModulesdata = document.querySelector('[backmodules]');
            let backModules = (JSON.parse(atob(backModulesdata.getAttribute("data-json"))));

            var frontmodulesdata = document.querySelector('[frontmodules]');
            let frontmodules = (JSON.parse(atob(frontmodulesdata.getAttribute("data-json"))));

            var extentionmodulesdata = document.querySelector('[extentionmodules]');
            let extentionmodules = (JSON.parse(atob(extentionmodulesdata.getAttribute("data-json"))));

            let mdllst;
            // var modules;
            let modules;


            let exlist = [];
            for (let ext in extentionmodules) {
                if (Object.keys(extentionmodules[ext]) != "")
                    exlist[Object.keys(extentionmodules[ext])] = extentionmodules[ext][Object.keys(extentionmodules[ext])];
            }
            modules = Object.assign({}, backModules, frontmodules, exlist);
            console.log(modules)




            var additemdata = document.querySelector('[reset-sidebar_settings_form]');
            options.content = (JSON.parse(atob(additemdata.getAttribute("data-json"))));
            $("ul.sidebar_form_list").makeForm(options);

            let menu_title_list = [];
            $('[data-sidebar="menu_title"]').each(function () {
                let title = $(this).val();
                if (title != "") {
                    menu_title_list.push(title)
                }

            })


            $('[data-sidebar="parent_select"]').each(function () {
                let options = ""
                for (let i = 0; i < menu_title_list.length; i++) {
                    options += '<option value="' + menu_title_list[i] + '">' + menu_title_list[i] + '</option>'
                }
                $(this).html(options)
            })
        })



        var titledata = document.querySelector('[title-sidebar_settings_form]');
        options.list = false;
        options.content = (JSON.parse(atob(titledata.getAttribute("data-json"))));
        $(".sidebar_title").makeForm(options);
    }
    var mdl = function () {
        $("#menu_list,#backmodule_list,#frontmodule_list,#extentionmodule_list,#submenu_list").sortable({
            connectWith: ".connectedSortable",
            opacity: 0.5,
            delay: 250,
            start: function (event, ui) {
                // console.log("start")
            },
            stop: function (event, ui) {
                //console.log("stop")
            },
            sort: function (event, ui) {
                //console.log("sort")
            },
            activate: function (event, ui) {
                //  console.log("activate")
            },
            update: function (e, ui) {
//                console.log(e)
//                console.log(ui)

                var item, page_title, controller, router, icon;
                item = ui.item[0];
                page_title = ui.item[0].attributes["module-page_title"].value;
                //controller = ui.item[0].attributes["module-controller"].value;
                router = ui.item[0].attributes["module-router"].value;
                icon = ui.item[0].attributes["module-icon"].value;
                let key = Math.round(Math.random() * 10000);
                if (e.target.id == "menu_list") {
                    item.innerHTML = `<div class="list-item-content"><h3 class=""><a href="javascript:void(0)">${page_title} 
                <input type="hidden" class="form-control" value="${key}" name="@sidebar_menu_fields$secret_number:${key}" /> 
                <input type="hidden" class="form-control" value="${page_title}" name="@sidebar_menu_fields$menu_title:${key}" /> 
                <input type="hidden" class="form-control" value="${router}" name="@sidebar_menu_fields$link:${key}" /> 
                <input type="hidden" class="sidebar_row_number" value="0" name="@sidebar_menu_fields$row_number:${key}" /> 
                <span style="position: absolute;right: 65px;width: 40%;margin-top: -10px;">
                <input type="input" class="form-control" value="${icon}" placeholder="Menu için bir ikon belirleyin" name="@sidebar_menu_fields$icon:${key}" />
                </span> 
                </a></h3></div>`


                    var row_numbers = document.getElementsByClassName("sidebar_row_number");
                    for (let i = 1; i < row_numbers.length + 1; i++) {
                        row_numbers[i].value = i
                    }
                } else {
                    item.innerHTML = `<div class="list-item-content"><h3 class=""><a href="javascript:void(0)">${router}</a></h3></div>`
                }





            }

        })
    }
    return {
        init: function () {
            //  module_form();
            mdl()
        }
    }
}();
jQuery(document).ready(function () {
    sidebar_settings_form.init(); // init metronic core componets
});