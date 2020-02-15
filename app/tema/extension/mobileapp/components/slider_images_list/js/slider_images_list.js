var slider_images_list = function () {

    var searchbox = function () {
        const searchType = document.getElementsByClassName("check_search_type")

        for (let i = 0; i < searchType.length; i++) {
            searchType[i].addEventListener("change", (e) => {
                var $thisVal = e.target.value;
                var $this_secret_number = e.target.getAttribute("secret_number");
                const searchBox = document.querySelectorAll('[data-search_type]')

                for (let n = 0; n < searchBox.length; n++) {
                    const datatype = searchBox[n].getAttribute("data-search_type");
                    const data_secret_number = searchBox[n].getAttribute("secret_number");
                    if ($this_secret_number == data_secret_number) {
                        searchBox[n].style.display = 'none';
                    }
                }
                for (let n = 0; n < searchBox.length; n++) {
                    const datatype = searchBox[n].getAttribute("data-search_type");
                    const data_secret_number = searchBox[n].getAttribute("secret_number");
                    if (datatype == $thisVal && $this_secret_number == data_secret_number) {
                        searchBox[n].style.display = 'block';
                    }
                }
            })
        }
    }
    var remove_item = function () {
        const removeItem = document.querySelectorAll('[remove-listitem]')
        for (let i = 0; i < removeItem.length; i++) {
            removeItem[i].addEventListener("click", function (e) {
                e.preventDefault();
                var $this_secret_number = e.target.getAttribute("secret_number");
                var $this_key = e.target.getAttribute("key");
                const listItem = document.querySelectorAll(".list-group-item")
                for (let n = 0; n < listItem.length; n++) {
                    const list_item_secret_number = listItem[n].getAttribute("secret_number");

                    if (list_item_secret_number == $this_secret_number) {
                        listItem[n].remove()
                        if (typeof $this_key !== "undefined") {
                            let options = {};
                            options = {
                                component_name: "slider_images_list",
                                component_action: "remove",
                                component_object: {key: $this_key}
                            }

                            component_run.run(options)
                        }
                    }


                }
            })
        }
    }
    var checked = function () {
        $(".check_search_type").on("change", function () {
            let val = $(this).val();
            $(this).parents("li").find(".screen").html("")
            if (val == "no") {
                $(this).parents("li").find(".selected_screen").html('<p><strong>Yönlendirme Yok</strong></p>')
            } else {
                $(this).parents("li").find(".selected_screen").html('<p><strong>Arama Yapın</strong></p>')
            }

        })
    }
    var fancy = function () {
        $('[data-fancybox="gallery"]').fancybox();
    }
    var search_product = function () {
        const  options = {component_name: "slider_images_list", action: "search_product"};
        var $search_product = $('[data-searchbox="product"]')
        $search_product.select2({
            placeholder: "Ürünlerden seçin",
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
        $search_product.on("select2:select", (e) => {
            //const selected_value = $(this).val()
            //console.log(selected_value)
            //console.log(e.params)
            var data = e.params.data;
            const secretnumber = e.target.getAttribute("secret_number")
            const secreens = document.getElementsByClassName("screen")
            const selected_screen = document.getElementsByClassName("selected_screen")
            for (let n = 0; n < secreens.length; n++) {
                const screen_secret_number = secreens[n].getAttribute("secret_number")
                if (screen_secret_number == secretnumber) {
                    selected_screen[n].innerHTML = '<p>Seçili Yönlendirme Ekranı : <strong>' + data.search_keyword + '</strong></p>'
                    secreens[n].innerHTML = '<input type="hidden" name="@application_main_slider$screen:' + secretnumber + '" value="' + data.id + '" />'
                }
            }
        });
    }

    var search_category = function () {

        const  options = {component_name: "slider_images_list", action: "search_category"};
        var $search_category = $('[data-searchbox="category"]')
        $search_category.select2({
            placeholder: "Kategorinizi Seçin",
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
        $search_category.on("select2:select", (e) => {
            //const selected_value = $(this).val()
            //console.log(selected_value)
            var data = e.params.data;
            const secretnumber = e.target.getAttribute("secret_number")
            const secreens = document.getElementsByClassName("screen")
            const selected_screen = document.getElementsByClassName("selected_screen")
            for (let n = 0; n < secreens.length; n++) {
                const screen_secret_number = secreens[n].getAttribute("secret_number")
                if (screen_secret_number == secretnumber) {
                    selected_screen[n].innerHTML = '<p>Seçili Yönlendirme Ekranı : <strong>' + data.search_keyword + '</strong></p>'
                    secreens[n].innerHTML = '<input type="hidden" name="@application_main_slider$screen:' + secretnumber + '"  value="' + data.id + '"/>'
                }
            }
        });

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

    return {
        init: function () {
            searchbox();
            fancy();
            search_product();
            search_category();
            remove_item();
            checked();
        }
    }
}()
