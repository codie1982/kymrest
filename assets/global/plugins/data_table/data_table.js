$.fn.data_table = function (options, callback) {
    var $this = this;
    var defaults = {
        start: 1,
        end: 10,
        direction: "desc",
        id: "",
        keyword: [],
        search: false,
        multiple_search: false,
        search_placeholder: "",
        component_name: "",
        getdata_action: "getdata",
        draw_action: "draw",
        update_action: "draw",
        actionfunction: function (data) {},
        get_data_url: data_url,
        get_draw_url: draw_url,
    }
//component_name

    const table = 0;
    var settings = Object.assign({}, defaults, options)

    $this.parent().prepend(`<input type="hidden" name="${settings.component_name}_settings" />`)
    set_table(false);
    function set_table(updt) {
        var table_settings_input = document.querySelector('[name="' + settings.component_name + '_settings"]')
        table_settings_input.value = JSON.stringify(settings)
        let options = {};
        options = {
            component_name: settings.component_name,
            action: settings.getdata_action,
        }


        $.ajax({type: "post",
            url: component_controller_url(options),
            data: settings,
            dataType: "json",
            beforeSend: function () {
                // $this.html("Yükleniyor...")
            },
            success: function (data) {
                if (data.sonuc) {
                    if (!updt) {
                        draw($this, data.result, data.total);
                    } else {
                        update($this, data.result, data.total);
                    }

                }
            }
        });
    }

    function data_url() {
        const  options = {
            component_name: settings.component_name,
            getdata_action: "getdata",
            draw_action: "getdata",
            update_action: "getdata",

        }
        return component_controller_url(options);
    }
    function draw_url() {
        const  options = {
            component_name: settings.component_name,
            getdata_action: "getdata",
            draw_action: "getdata",
            update_action: "getdata",

        }
        return component_controller_url(options)
    }


    function get_pageno() {
        let page_no;
        $('[data-product="page_number"]').find("button").each(function () {
            if ($(this).hasClass("blue")) {
                page_no = $(this).data("page")
            }
        })
        return parseInt(page_no);
    }
    function page_button() {
        $('[table-page]').off()
        $('[table-page]').on("click", function (e) {
            e.preventDefault();
            var start = 0, end = 0, item_count = 0;
            const tablekey = e.target.attributes.tablekey.value;
            const selected_page_no = $(this).attr("table-page");
            if (selected_page_no !== "first" && selected_page_no !== "last") {
                set_page(tablekey, selected_page_no);
                item_count = get_item_count(tablekey);
                start = parseInt(selected_page_no - 1) * parseInt(item_count);
                end = start + parseInt(item_count);
            }
//console.log(start, end, item_count)
            let state = {
                start: start,
                end: end,
                control_class: settings.component_name,
                control_function: "getdata",
                tablekey: tablekey,
            }
            setsettings(state)
        })
    }
    function select_page() {
        $('[table-control="selected_page"]').off()
        $('[table-control="selected_page"]').on("change", function (e) {

            var start = 0, end = 0, item_count = 0;
            const tablekey = e.target.attributes.tablekey.value;
            const selected_page_no = $(this).val();
            if (selected_page_no !== "first" && selected_page_no !== "last") {
                item_count = get_item_count(tablekey);
                start = parseInt(selected_page_no - 1) * parseInt(item_count);
                end = start + parseInt(item_count);
            }
//console.log(start, end, item_count)
            let state = {
                start: start,
                end: end,
                control_class: settings.component_name,
                control_function: "getdata",
                tablekey: tablekey,
            }
            setsettings(state)
        })
    }
    function select_show_item() {
        $('[table-control="show_item"]').off()
        $('[table-control="show_item"]').on("change", function (e) {

            var start = 0, end = 0, item_count = 0;
            const tablekey = e.target.attributes.tablekey.value;
            const selected_page_no = get_page_number(tablekey);
            if (selected_page_no !== "first" && selected_page_no !== "last") {
                item_count = $(this).val();
                start = parseInt(selected_page_no - 1) * parseInt(item_count);
                end = start + parseInt(item_count);
            }
//console.log(start, end, item_count)
            let state = {
                start: start,
                end: end,
                control_class: settings.component_name,
                control_function: "getdata",
                tablekey: tablekey,
            }
            setsettings(state)
        })
    }
    function setsettings(state) {
        var table = $("#" + state.tablekey);
        $this = table.parent();
        if (typeof state.control_class !== "undefined") {
            state.component_name = $this[0].id
        } else {
            state.component_name = state.control_class
        }
        state.getdata_action = state.control_function

        settings = Object.assign({}, settings, state)
        let table_update = true;
        set_table(table_update);
    }
    function set_page(tablekey, selected_page) {
        var table = $("#" + tablekey);
        table.find('[table-page]').each(function () {
            $(this).removeClass("blue")
            if ($(this).attr("table-page") == selected_page) {
                $(this).addClass("blue")
            }
        })
    }
    function get_item_count(tablekey) {
        var table = $("#" + tablekey);
        //table-control="show_result"
        var item_count = table.find('[table-control="show_item"]').children(":selected").val();
        return item_count
    }
    function get_page_number(tablekey) {
        var table = $("#" + tablekey);
        //table-control="show_result"
        var page_number = table.find('[table-control="selected_page"]').children(":selected").val();
        return page_number
    }
    function draw($this, tabledata, total_data) {
        const  options = {component_name: settings.component_name, action: settings.draw_action, }
        $.ajax({type: "post",
            url: component_controller_url(options),
            data: {
                "start": settings.start,
                "end": settings.end,
                "total": total_data,
                "tabledata": tabledata,
            },
            dataType: "json",
            beforeSend: function () {
                // $this.html("Çiziliyor...")
            },
            success: function (data) {
                if (data.sonuc) {
                    $this.html(data.render)
                    if (typeof settings.actionfunction !== "undefined") {
                        settings.actionfunction.call(data);
                    }
                    //aktif Sayfa Numarasını
                    get_pageno()
                    //hedef Sayfa Numarasını
                    page_button()
                    select_page()
                    select_show_item()
                    table_filter();
                    table_refresh();
                    table_allcheck();
                    if (settings.search) {
                        var $search_item = $('[data-table="search_input"]')
                        search_data($search_item);
                        const selected_value = $search_item.val()

                        $search_item.on("select2:select", (e) => {
                            //const selected_value = $(this).val()
                            //console.log(selected_value)
                            //console.log(e.params)
                            var data = e.params.data;
                            const tablekey = $search_item.attr("table-key");

                            let state = {
                                id: data.id,
                                keyword: data.search_keyword,
                                type: data.type,
                                control_class: settings.component_name,
                                control_function: "searchdata",
                                tablekey: tablekey,
                            }
                            setsettings(state)
                        });
                    }
                }
            }
        });
    }

    function table_filter() {
        $('[table-filter]').on("click", (e) => {
            e.preventDefault();
            const tablekey = e.target.attributes.tablekey.value;
            var control_class = e.target.attributes["control_class"].value
            var control_function = e.target.attributes["control_function"].value

            let state = {
                control_class: control_class,
                control_function: control_function,
                tablekey: tablekey,
            }
            setsettings(state)
        })
    }

    function table_refresh() {
        $('[table-action="refresh"]').on("click", (e) => {
            e.preventDefault();
            const tablekey = e.target.attributes.tablekey.value;
            let state = {
                end: 10,
                control_class: settings.component_name,
                control_function: "getdata",
                tablekey: tablekey,
            }
            setsettings(state)
        })
    }
    function table_allcheck() {
        $('[data-table="allchecked"]').on("change", (e) => {
            var checked = e.target.checked;
            var tablekey = e.target.attributes["tablekey"].value;
            var selected_keys = [];
            $("#" + tablekey).find("tbody tr").each(function () {
                var td = $(this).find("td");
                if (checked) {
                    td.find('input[type="checkbox"]').prop("checked", true)
                    var selected_key = td.find('input[type="checkbox"]').attr("primarykey")
                    selected_keys.push(selected_key)
                } else {
                    td.find('input[type="checkbox"]').prop("checked", false)
                }

            })
            var value = selected_keys.join(",");
            var button = $("#" + tablekey).find('[data-button="remove_button"]')
            button.attr("data-component_data", value)
        })
    }
    function update($this, tabledata, total_data) {

        var $tbody = document.getElementById("tbody")
        const  options = {component_name: settings.component_name, action: settings.update_action, }
        $.ajax({type: "post",
            url: component_controller_url(options),
            data: {
                "start": settings.start,
                "end": settings.end,
                "total": total_data,
                "tabledata": tabledata,
                "update": true,
            },
            dataType: "json",
            beforeSend: function () {

                // $tbody.innerHTML = "Çiziliyor...";
            },
            success: function (data) {

                if (data.sonuc) {
                    $tbody.innerHTML = data.render
                    //$this.html(data.render)
                    if (typeof settings.actionfunction !== "undefined") {
                        settings.actionfunction.call(data);
                    }
                    //aktif Sayfa Numarasını
//                    get_pageno()
//                    //hedef Sayfa Numarasını
//                    page_button()
//                    select_page()
//                    select_show_item()

                }
            }
        });
    }

    function search_data($search_item) {
        const  options = {component_name: settings.component_name, action: "search"};
        $search_item.select2({
            placeholder: settings.search_placeholder,
            width: '100%',
            language: "tr",
            ajax: {
                url: component_controller_url(options),
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var query = {
                        q: params.term,
                    }
                    return query;
                },
                processResults: function (data) {

                    return {
                        results: data.items
                    };
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: formatState,
            templateSelection: formatRepoSelection,
        })
    }
    function formatState(repo) {
        // console.log(repo);
        var $state = $('<span>' + repo.search_keyword + '</span>');
        return $state;
    }
    function formatRepoSelection(repo) {
        //console.log(repo);
        return repo.search_keyword;

    }



}