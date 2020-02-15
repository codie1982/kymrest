/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var general_settings_form = function () {
    var search_company = function () {
        const  options = {component_name: "general_settings_form", action: "search_company"};
        var $search_product = $('[data-searchbox="company"]')
        $search_product.select2({
            placeholder: "Kendi Firmanızı Seçin",
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
            var data = e.params.data;
            console.log(data)
            $("#myCompany").val(data.id)

            const options = {
                component_name: "general_settings_mycompany",
                component_action: "load",
                component_object: {
                    company_id: data.id
                },
                starter:"component_run"
            }
            component_run.run(options)

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
            search_company();
        }
    }
}();
jQuery(document).ready(function () {
    general_settings_form.init(); // init metronic core componets
});