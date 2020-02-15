/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var job_form = function () {
    var wizard = function () {
        // default form wizard
        $('#form_wizard_1').bootstrapWizard({
            'nextSelector': '.button-next',
            'previousSelector': '.button-previous',
            onTabClick: function (tab, navigation, index, clickedIndex) {
                return false;

                success.hide();
                error.hide();
                if (form.valid() == false) {
                    return false;
                }

                handleTitle(tab, navigation, clickedIndex);
            },
            onNext: function (tab, navigation, index) {
                success.hide();
                error.hide();

                if (form.valid() == false) {
                    return false;
                }

                handleTitle(tab, navigation, index);
            },
            onPrevious: function (tab, navigation, index) {
                success.hide();
                error.hide();

                handleTitle(tab, navigation, index);
            },
            onTabShow: function (tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                var $percent = (current / total) * 100;
                $('#form_wizard_1').find('.progress-bar').css({
                    width: $percent + '%'
                });
            }
        });

        $('#form_wizard_1').find('.button-previous').hide();
        $('#form_wizard_1 .button-submit').click(function () {
            alert('Finished! Hope you like it :)');
        }).hide();
    }

    var search_customer = function () {
        var $search_item = $("#customer_search")
        const  options = {component_name: "job_form", action: "search_customer"};
        $search_item.select2({
            placeholder: "Müşterileriniz Arasında Arama Yapın",
            dropdownParent: $("#jobs"),
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

        $search_item.on("select2:select", (e) => {

            const selected_value = $search_item.val()
            var data = e.params.data;
            const options = {
                component_name: "job_new",
                component_action: "load",
                component_object: {"customer_id": data.id, "customer_name": data.search_keyword},
                starter: "form,component_run"
            }
            component_run.run(options)

        });
        function formatState(repo) {
            return $('<span>' + repo.search_keyword + '</span>');
        }
        function formatRepoSelection(repo) {
            return repo.search_keyword;
        }
    }
    var search_product = function () {
        var $search_item = $("#products_search")
        const  options = {component_name: "job_form", action: "search_product"};
        $search_item.select2({
            placeholder: "Ürünleriniz Arasında Arama Yapın",
            dropdownParent: $("#jobs"),
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


        $search_item.on("select2:select", (e) => {
            const selected_value = $search_item.val()
            const jobid = document.querySelector('[selected_job_id]').getAttribute("selected_job_id");
            const customer_id = document.querySelector('[customer_id]').getAttribute("customer_id");
            console.log(customer_id, jobid)
            const options = {
                component_name: "job_form_products_detail",
                component_action: "load",
                component_object: {"selected_product_id": selected_value, "selected_job_id": jobid, "customer_id": customer_id},
                starter: "form,component_run"
            }
            component_run.run(options)

        });
        function formatState(repo) {
            return $('<span>' + repo.search_keyword + '</span>');
        }
        function formatRepoSelection(repo) {
            return repo.search_keyword;
        }
    }
    return {
        init: function () {
            wizard()
            search_customer()
            search_product()

        }
    }
}();
jQuery(document).ready(function () {
    job_form.init(); // init metronic core componets
});