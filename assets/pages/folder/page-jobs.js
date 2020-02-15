/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var page_jobs = function () {
    function formatStateCustomer(repo) {
        var $state = $('<span>' + repo.cname + '</span>');
        return $state;
    }
    function formatRepoSelectionCustomer(repo) {
        return repo.cname;
    }
    var select_customer = function () {
        var placeholder = "İsim|email|müşteri kodu";
        var $scustomer = $('[data-search="customer"]')
        var scriptURL = "/xhr/sendcustomer/searchcostumer";
        $scustomer.select2({
            placeholder: placeholder,
            width: null,
            maximumSelectionLength: 1,
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
                    console.log(data)
                    return {
                        results: data.items
                    };
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: formatStateCustomer,
            templateSelection: formatRepoSelectionCustomer,
        })
        $scustomer.on("select2:select", function (e) {
            var customer_adres_select = $('[data-customer="customer_adres"]')
            var $select;
            $select = '<option value="---">Bir Adres Seçiniz</option>';
            var scriptURL = "/xhr/sendcustomer/getcustomeradres";
            $.ajax({type: "post",
                url: scriptURL,
                data: {"costumer_seccode": $scustomer.val()},
                dataType: "json",
                beforeSend: function () {
                    $("body").find(".waiting_screen").fadeIn()
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()
                    if (data.sonuc) {
                        var adres_items_count = Object.keys(data.adres_items).length
                        var i = 0;
                        for (i = 0; i < adres_items_count; i++) {
                            $select += '<option value="' + data.adres_items[i].id + '">' + data.adres_items[i].title + '</option>'
                        }
                        customer_adres_select.html($select)
                        toastr["success"](data.msg)
                    } else {

                        toastr["error"](data.msg)
                    }
                }
            });
        });
    }


    function formatStateProduct(repo) {
        var $state = $('<span>' + repo.pname + '</span>');
        return $state;
    }
    function formatRepoSelectionProduct(repo) {
        return repo.pname;
    }

    var select_product = function () {
        var placeholder = "Ürün İsmi|Ürün Kodu";
        var $sproduct = $('[data-search="product"]')
        var scriptURL = "/xhr/sendproduct/searchProductItem";
        $sproduct.select2({
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
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: formatStateProduct,
            templateSelection: formatRepoSelectionProduct,
        })

        $sproduct.on("select2:unselect", function (e) {
            var selected_product = $sproduct.val();
            if (selected_product == null) {
                $("#job_product_table").product_table({
                    html: true,
                    start: 0,
                    end: 1,
                    show: 1,
                    product: "---",
                    product_type: "jobItem"
                })
            } else {
                var productCount = $sproduct.val().length
                $("#job_product_table").product_table({
                    html: true,
                    start: 0,
                    end: productCount,
                    show: productCount,
                    product: $sproduct.val(),
                    product_type: "jobItem"
                })
            }
        })
        $sproduct.on("select2:select", function (e) {
            var productCount = $sproduct.val().length
            $("#job_product_table").product_table({
                html: true,
                start: 0,
                end: productCount,
                show: productCount,
                product: $sproduct.val(),
                product_type: "jobItem"
            })

        });
    }
    var search_job = function () {
        var placeholder = "Müşteri İsmi|Müşteri Kimlik Numarası";
        var $sproduct = $('[data-search="jobs"]')
        var scriptURL = "/xhr/sendproduct/searchProductItem";
        $sproduct.select2({
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
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: formatStateProduct,
            templateSelection: formatRepoSelectionProduct,
        })

        $sproduct.on("select2:unselect", function (e) {})
        $sproduct.on("select2:select", function (e) {});
    }

    var changeSearchAdres = function () {
        $('[name="job_search_adres"]').on("change", function () {
            if ($(this).prop("checked")) {
                $(".search_section").find('[data-search_section="search_jobs"]').hide()
                $(".search_section").find('[data-search_section="search_jobs_adres"]').show()
            } else {
                $(".search_section").find('[data-search_section="search_jobs"]').show()
                $(".search_section").find('[data-search_section="search_jobs_adres"]').hide()
            }
        })
    }

    var refresh_table = function () {
        $('[data-refresh="job_table"]').on("click", function (e) {
            e.preventDefault();
            let param = $('[name="table_settings"]').val()
            console.log(param)
            param === "" ? $("#job_table").job_table({"html": true}) : $("#job_table").job_table(JSON.parse(param))
        })
    }

    var load_table_event = () => {
        $("#job_table").job_table();
    }
    var refreshJobTale = function () {

    }
    var search_jobs_adres = function () {
        $('[data-search="jobs_adres_section"]').adres_html_block({
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
    var product_stock_count = function () {
        $('[data-product="product_item"]').TouchSpin({
            min: 1,
            max: 100,
            boostat: 1,
            verticalbuttons: false,
            verticalupclass: 'glyphicon glyphicon-plus',
            verticaldownclass: 'glyphicon glyphicon-minus'
        });
    }


//data-jobs="remove_all"

    var remove_all = function () {
        $('[data-jobs="remove_all"]').on("click", function (e) {
            e.preventDefault();
            var job_seccode;
            var removeJobs = confirm("Seçili İşlerin Tümünü Kaldırmak İstiyormusunuz?")
            if (removeJobs) {
                $("#job_table").find("table tr").each(function () {
                    var checkbox = $(this).children("td").find('input[type="checkbox"]')
                    console.log(checkbox);
                    if (checkbox.prop("checked")) {
                        job_seccode = checkbox.data("job_seccode");
                        $("#job_table").job_table().removejob(job_seccode)
                    }
                })
            } else {
                toastr["success"]("Tebrikler Ürünleri Silmeyin :))")

            }

        })
    }

    var add_new_jobs = function () {

        $('[data-job="addNewJob"]').on("click", function () {
            $('[data-search="customer"]').val(null).trigger('change');
            $('[data-customer="customer_adres"]').val(null).trigger('change');
            $('[data-search="product"]').val(null).trigger('change');
            $('[data-search="product"]').val(null).trigger('change');
            $("#job_product_table").html("");
        })
    }

    var change_payment_method_select = function () {

        $('[name="job_payment_method"]').on("change", function () {
            if ($(this).val() == "credicart") {
                $(".credicart_section").show()
            } else {
                $(".credicart_section").hide()
            }

        })
    }
    return {
        init: function () {
            select_customer(); // handle adres Blok
            select_product(); // handle adres Blok
            product_stock_count();
            search_job();
            changeSearchAdres();
            search_jobs_adres();
            refreshJobTale();
            refresh_table();
            remove_all();
            load_table_event();
            add_new_jobs();
            change_payment_method_select();
        }
    }
}();
jQuery(document).ready(function () {
    page_jobs.init(); // init metronic core componets
});