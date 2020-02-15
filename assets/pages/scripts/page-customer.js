/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var page_costumer = function () {
    function formatState(repo) {
        console.log(repo);
        if (!repo.id) {
            return repo.text;
        }
        if ($('[name="costumer_search_adres"]').prop("checked")) {
            var $state = $('<span>' + repo.cname + '</span>');
        } else {
            var $state = $('<span>' + repo.cname + '</span>');
        }

        return $state;
    }

    function formatRepoSelection(repo) {
        if ($('[name="costumer_search_adres"]').prop("checked")) {
            return repo.cname || repo.text;
        } else {
            return repo.cname || repo.text;
        } 

    }
    function formatRepo(repo) {
        console.log(repo)
        if (repo.loading)
            return repo.text;
        var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__avatar'></div>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";
        if (repo.description) {
            markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
        }

        markup += "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks'><span class='glyphicon glyphicon-flash'></span> " + repo.forks_count + " Forks</div>" +
                "<div class='select2-result-repository__stargazers'><span class='glyphicon glyphicon-star'></span> " + repo.stargazers_count + " Stars</div>" +
                "<div class='select2-result-repository__watchers'><span class='glyphicon glyphicon-eye-open'></span> " + repo.watchers_count + " Watchers</div>" +
                "</div>" +
                "</div></div>";
        return markup;
    }

    var search_customer = function () {
        var placeholder = "Kullanıcı İsmi|mail Adresi|Kullanıcı Kodu|telefon Numarası";
        var $search_customer = $('[data-search="search_customer"]')

        var scriptURL = "/xhr/sendcustomer/searchcostumer";
        $search_customer.select2({
            placeholder: placeholder,
            width: null,
            language: "tr",
            ajax: {
                url: scriptURL,
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
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: formatState,
            templateSelection: formatRepoSelection,
        })
        $search_customer.on("select2:unselect", function () {
            if ($search_customer.val() != null) {
                var start_page,
                        _start_page,
                        show_count;
                $('[data-table="page_number"]').find("button").each(function () {
                    if ($(this).hasClass("blue")) {
                        start_page = $(this).data("page");
                    }
                })

                show_count = $('[data-table="show_result"]').children("option:selected").val()
                if (show_count == "---") {
                    show_count = 5;
                }

                _start_page = (parseInt(start_page) - 1) * parseInt(show_count)

                var pTable = $("#costumer_table").client_table({
                    html: true,
                    start: parseInt(_start_page),
                    end: parseInt(_start_page) + parseInt(show_count),
                    show: parseInt(show_count),
                    client_seccode: $search_customer.val(),
                });
            } else {
                var start_page,
                        _start_page,
                        show_count;
                $('[data-table="page_number"]').find("button").each(function () {
                    if ($(this).hasClass("blue")) {
                        start_page = $(this).data("page");
                    }
                })

                show_count = $('[data-table="show_result"]').children("option:selected").val()
                if (show_count == "---") {
                    show_count = 5;
                }

                _start_page = (parseInt(start_page) - 1) * parseInt(show_count)

                var pTable = $("#costumer_table").client_table({
                    html: true,
                    start: parseInt(_start_page),
                    end: parseInt(_start_page) + parseInt(show_count),
                    show: parseInt(show_count),
                    client_seccode: "---",
                });
            }
        })
        $search_customer.on("select2:select", function (e) {


            var start_page,
                    _start_page,
                    show_count;
            $('[data-table="page_number"]').find("button").each(function () {
                if ($(this).hasClass("blue")) {
                    start_page = $(this).data("page");
                }
            })

            show_count = $('[data-table="show_result"]').children("option:selected").val()
            if (show_count == "---") {
                show_count = 5;
            }

            _start_page = (parseInt(start_page) - 1) * parseInt(show_count)

            var pTable = $("#costumer_table").client_table({
                html: true,
                start: parseInt(_start_page),
                end: parseInt(_start_page) + parseInt(show_count),
                show: parseInt(show_count),
                client_seccode: $search_customer.val(),
            });
        });
    }


    var search_customer_adres = function () {
        $('[data-search="customer_adres_section"]').adres_html_block({
            adres_type: "search_block",
            html: true,
        })

        $('[data-search="search_costumer_from_adres"]').on("click", function () {
            var province = $('[data-select_adres="province"]').val()
            var district = $('[data-select_adres="district"]').val()
            var neighborhood = $('[data-select_adres="neighborhood"]').val()
            if (province != "") {
                $("#costumer_table").client_table({
                    html: true,
                    adres: true,
                    province: province,
                    district: district,
                    neighborhood: neighborhood,
                });
            } else {
                alert("Bir İl Seçiniz")
            }

        }
        )
    }

    function formatStateAdres(repo) {

//            AAmhlKoyAdi as kyAdi,
//            AASmtBckAdi as smtAdi,
//            AAilceAdi as ilceAdi,
//            AAilAdi as ilAdi 

        var $state = $('<span>' + repo.ilAdi + '/' + repo.AAilceAdi + '/' + repo.AASmtBckAdi + '/' + repo.AAmhlKoyAdi + '</span>');
        return $state;
    }
    function formatState(repo) {
        var $state = $('<span>' + repo.cname + '</span>');
        return $state;
    }


    function formatRepoSelectionAdres(repo) {
        return repo.ilAdi + '/' + repo.AAilceAdi + '/' + repo.AASmtBckAdi + '/' + repo.AAmhlKoyAdi;
    }

    function formatRepoSelection(repo) {
        return repo.cname;
    }

    var handleSummernote = function () {
        $('#summernote').summernote(
                {
                    toolbar: [
                        // [groupName, [list of button]]

                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']]

                    ],
                    height: 200,
                    onfocus: function (e) {

                        $('body').addClass('overlay-disabled');

                    },
                    onblur: function (e) {

                        $('body').removeClass('overlay-disabled');

                    }



                });
        //API:
        //var sHTML = $('#summernote_1').code(); // get code
        //$('#summernote_1').destroy(); // destroy
    }

    var adres_block = function () {
        $('[data-customer="add-new-customer-adres-button"]').on("click", function (e) {
            e.preventDefault();
            var costumer_seccode = $(this).data("customer-seccode");
            if (typeof costumer_seccode !== "undefined") {
                $('[data-company="adres_info"]').adres_html_block({
                    html: true,
                    costumer_seccode: costumer_seccode
                });
            } else {
                $('[data-company="adres_info"]').adres_html_block({
                    html: true
                });
            }
        })
    }
    var handleCompanyTaxProvince = function () {
        $('[data-select="tax_section"]').tax_seciton_block({
            "html": false
        });
    }

    var changeSearchAdres = function () {
        $('[name="costumer_search_adres"]').on("change", function () {
            if ($(this).prop("checked")) {
                $(".search_section").find('[data-search_section="search_customer"]').hide()
                $(".search_section").find('[data-search_section="search_customer_adres"]').show()
            } else {
                $(".search_section").find('[data-search_section="search_customer"]').show()
                $(".search_section").find('[data-search_section="search_customer_adres"]').hide()
            }
        })
    }
    var handleCompanyAccountSection = function () {
        $('[data-select="add-new-account-section"]').on("click", function (e) {
            e.preventDefault();
            $('[data-company="account_info"]').company_account_html_block({
                "html": true
            });
        })
    }
    var handleAddNewAdresBlock = function () {

        $('[data-customer="add-new-adres-button"]').on("click", function (e) {
            e.preventDefault();
            $('[data-company="adres_info"]').adres_html_block({
                "adres_type": "settings"
            });
        })


    }
    var handleAddNewPhoneBlock = function () {

        $('[data-customer="add-new-phone-button"]').on("click", function (e) {
            e.preventDefault();
            $('[data-company="phone_info"]').phone_html_block()
        })

    }
    var handleAddNewCrediCardBlock = function () {
// credicard.init();
        $('[data-customer="add-new-credicard-button"]').on("click", function (e) {
            e.preventDefault();
            $('[data-company="credicard_info"]').credicard_html_block()
        })
    }
    var handleSelectCustomerType = function () {
        $('[data-customer="select-type"]').on("change", function () {
            var selected_value = $(this).val();
            $("body").find('[data-customer-type]').each(function () {
                $(this).hide();
            })
            $("body").find('[data-customer-type="' + selected_value + '"]').show();
        })

    }

    var handleNewCostumer = function () {
        $('[data-customer="add_new_customer"]').on("click", function () {
            var form = $('[data-form="xhr"]');
            form.find('[name="client_seccode"]').remove()
            form.find('[name="customer_fullname"]').val("")
            form.find('[name="customer_email"]').val("")
            form.find('[name="costumer_send_mail"]').prop("checked", false)
            form.find('[name="customer_type"]').val("---").change()
            form.find('[data-company="adres_info"]').html("")
            form.find('[data-company="phone_info"]').html("")
            form.find('[data-company="credicard_info"]').html("")
            form.find('[name="customer_description"]').summernote("reset")
            //Reset
            form.attr("action", "/xhr/sendcustomer/newcustomer");
        })

    }

    var handleCostumerTable = function () {
        $("#costumer_table").client_table();

    }
    var handleRefreshCostumerTable = function () {
        $('[data-refresh="customer_table"]').on("click", function (e) {
            e.preventDefault()

            var start_page,
                    _start_page,
                    show_count;
            $('[data-table="page_number"]').find("button").each(function () {
                if ($(this).hasClass("blue")) {
                    start_page = $(this).data("page");
                }
            })

            show_count = $('[data-table="show_result"]').children("option:selected").val()
            if (show_count == "---") {
                show_count = 5;
            }
            console.log((parseInt(start_page) - 1) * parseInt(show_count))
            _start_page = (parseInt(start_page) - 1) * parseInt(show_count)
            console.log(parseInt(start_page) + parseInt(show_count))
            console.log(parseInt(show_count))
            $("#costumer_table").client_table({
                html: true,
                start: _start_page,
                end: parseInt(_start_page) + parseInt(show_count),
                show: parseInt(show_count),
            }
            );
        })


    }

    var remove_all = function () {


        $('[data-costumer="remove_all"]').on("click", function (e) {
            e.preventDefault();
            var start_page,
                    _start_page,
                    show_count;
            $('[data-table="page_number"]').find("button").each(function () {
                if ($(this).hasClass("blue")) {
                    start_page = $(this).data("page");
                }
            })

            show_count = $('[data-table="show_result"]').children("option:selected").val()
            if (show_count == "---" || isNan(show_count)) {
                show_count = 5;
            }
            _start_page = (parseInt(start_page) - 1) * parseInt(show_count)

            var costumer_seccode;
            $("#costumer_table").find("table tr").each(function () {
                var checkbox = $(this).children("td").find('input[type="checkbox"]')
                console.log(checkbox);
                if (checkbox.prop("checked")) {
                    costumer_seccode = checkbox.data("customer_seccode");
                    $("#costumer_table").client_table({
                        html: true,
                        start: _start_page,
                        end: parseInt(_start_page) + parseInt(show_count),
                        show: parseInt(show_count),
                    }).removecostumer(costumer_seccode)


                }
            })
        })
    }
    return {
        init: function () {
            search_customer(); // handle adres Blok
            search_customer_adres(); // handle adres Blok
            handleSummernote();
            adres_block();
            handleCompanyTaxProvince();
            handleCompanyAccountSection();
            handleAddNewAdresBlock();
            handleAddNewPhoneBlock();
            handleAddNewCrediCardBlock();
            handleSelectCustomerType();
            handleNewCostumer();
            handleCostumerTable();
            handleRefreshCostumerTable();
            remove_all();
            changeSearchAdres();
        }
    }
}();
jQuery(document).ready(function () {
    page_costumer.init(); // init metronic core componets
});