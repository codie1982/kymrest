$.fn.client_table = function (options) {
    var $this = this;
    var defaults = {
        html: false,
        client_seccode: "---",
        product: "all",
        start: 0,
        end: 10,
        show: 10,
        order: "desc",
        adres: false,
        province: 0,
        district: 0,
        neighborhood: 0,
    }
    var settings = $.extend({}, defaults, options);


    var _start = settings.start,
            _end = settings.end,
            _html = settings.html,
            _show = settings.show,
            _client_seccode = settings.client_seccode,
            _province = settings.province,
            _district = settings.district,
            _neighborhood = settings.neighborhood;

    if (_html) {
        addTable();
    }

    function addTable() {

        var scriptURL = "/xhr/sendcustomer/getcustomertable";
        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "adres": settings.adres,
                "province": _province,
                "district": _district,
                "neighborhood": _neighborhood,
                "client_seccode": _client_seccode,
                "start": _start,
                "end": _end,
                "show": _show,
                "condition": settings.condition,
                "order": settings.order,

            },
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                $this.html(data.table)
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim


                    $('[data-client="remove_client"]').off()
                    $('[data-client="remove_client"]').on("click", function () {
                        var client_seccode = $(this).data("client_seccode");
                        var btn = $(this);
                        removeCostumer(client_seccode, btn)
                    }
                    )


                    $('[data-client="edit_client"]').off()
                    $('[data-client="edit_client"]').on("click", function () {
                        var btn = $(this)
                        var client_seccode = btn.data("client_seccode");
                        editClientInfo(client_seccode)
                    }
                    )



                    $('[data-table="show_result"]').off();
                    $('[data-table="show_result"]').on("change", function () {
                        var $this = $(this)

                        show_count($this)
                    });

                    $('[data-table="page_number"]').on("click", "button", function () {
                        var $this = $(this)
                        page_number($this)
                    })

                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }

    $('[data-client="remove_client"]').off()
    $('[data-client="remove_client"]').on("click", function () {
        var client_seccode = $(this).data("client_seccode");
        var btn = $(this);
        removeCostumer(client_seccode, btn)
    }
    )

    $('[data-client="edit_client"]').off()
    $('[data-client="edit_client"]').on("click", function () {
        var btn = $(this)
        var client_seccode = btn.data("client_seccode");
        editClientInfo(client_seccode)
    }
    )


    function editClientInfo(client_seccode) {
        var scriptURL = "/xhr/sendcustomer/getcustomerinfo";
        var form = $('[data-form="xhr"]');
        $.ajax({type: "post",
            url: scriptURL,
            data: {"client_seccode": client_seccode},
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
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
                    form.attr("action", "/xhr/sendcustomer/editcustomer");


                    form.prepend('<input type="hidden" name="client_seccode" value="' + client_seccode + '" >')

                    form.find('[name="customer_fullname"]').val(data.client_name)
                    form.find('[name="customer_email"]').val(data.info.email)
                    form.find('[name="customer_type"]').val(data.info.type).change()
                    if (data.info.type == "personel") {
                        form.find('[name="customer_idnumber"]').val(data.info.customer_idnumber)
                    } else if (data.info.type == "company") {
                        form.find('[name="customer_company_title"]').val(data.info.customer_company_title)
                        form.find('[name="customer_company_tax_province"]').val(data.info.customer_company_tax_province).change()
                        form.find('[name="customer_company_tax_office"]').val(data.info.customer_company_tax_office)
                        form.find('[name="customer_company_tax_number"]').val(data.info.customer_company_tax_number)
                    }



                    var i = 0;
                    var html_block,
                            random;
                    var timep, timed, timen


                    var c = 0
                    var i = 0
                    var t = Object.keys(data.client_adres).length;
                    for (i = 0; i < Object.keys(data.client_adres).length; i++) {

                        form.find('[data-company="adres_info"]').adres_html_block({
                            costumer_seccode: data.info.customer_seccode,
                            adres_seccode: data.client_adres[i].adres_seccode,
                            adres_title: data.client_adres_title[i],
                            province: data.client_adres[i].province,
                            district: data.client_adres[i].district,
                            neighborhood: data.client_adres[i].neighborhood,
                            description: data.client_adres_description[i],
                            count: i,
                        });
                    }

                    for (i = 0; i < Object.keys(data.client_phone).length; i++) {
                        form.find('[data-company="phone_info"]').phone_html_block({
                            html: true,
                            costumer_seccode: data.info.customer_seccode,
                            phone_seccode: data.client_phone[i].phone_seccode,
                            phone_number: data.client_phone[i].phone,
                        });
                    }

                    for (i = 0; i < Object.keys(data.client_credicard).length; i++) {
                        form.find('[data-company="credicard_info"]').credicard_html_block({
                            html: true,
                            costumer_seccode: data.info.customer_seccode,
                            credicard_seccode: data.client_credicard[i].credi_card_seccode,
                            credicard_number: data.client_credicard[i].credi_card_number,
                            credicard_month: data.client_credicard[i].month,
                            credicard_year: data.client_credicard[i].year,
                        });
                    }


                    form.find('[name="customer_description"]').summernote('code', data.description);



                    toastr["success"](data.msg)
                } else {

                    toastr["error"](data.msg)
                }
            }
        });
    }

    $('[data-table="show_result"]').on("change", function () {
        var $this = $(this)
        show_count($this)
    });

    $('[data-table="page_number"]').on("click", "button", function () {
        var $this = $(this)
        page_number($this)
    })


    function show_count($this) {
        var value = $this.val();

        var page_no;
        $('[data-table="page_number"]').find("button").each(function () {

            if ($(this).hasClass("blue")) {
                page_no = $(this).data("page")
            }
        })
        var srt = (parseInt(page_no) - 1) * parseInt((value === "---" ? 10 : value))
        _html = true
        _start = srt
        _end = srt + parseInt((value === "---" ? 10 : value));
        _show = parseInt((value === "---" ? 10 : value))
        // console.log(settings)
        addTable();
    }

    function page_number($this) {

        $('[data-table="page_number"]').find("button").each(function () {
            if ($(this).hasClass("blue")) {
                $(this).removeClass("blue")
            }
        })
        $this.addClass("blue")

        var showitem = $('[data-product="show_result"]').val() === "---" ? 10 : $('[data-product="show_result"]').val()

        var page_no = $this.data("page")
        var selectedValue = $('[data-select_filter="category"]').select2("val");
//        console.log(selectedValue)
//        console.log(settings)
        _html = true
        var srt = (parseInt(page_no) - 1) * parseInt(showitem)
//        console.log(srt)
        _start = srt;
        _end = parseInt(_start) + parseInt(showitem);
//        console.log(settings)
        addTable();
    }

    function removeCostumer(costumer_seccode, btn) {
        var scriptURL = "/xhr/sendcustomer/removecostumer";
        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "costumer_seccode": costumer_seccode,
            },
            dataType: "json",
            beforeSend: function () {
                //<div class="row"><div class="col-sm-12"><div class="progress"><div class="progress-bar-indeterminate"></div></div></div></div>
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim
                    if (typeof btn !== "undefined") {
                        btn.parents("tr").fadeOut("500", function () {
                            $(this).remove()
                        })
                    } else {
                        $this.find("table tr").each(function () {
                            var checkbox = $(this).children("td").find('input[type="checkbox"]')
                            var checkbox_cosumer_seccode = checkbox.data("customer_seccode")
                            if (checkbox_cosumer_seccode == costumer_seccode) {
                                $(this).remove()
                            }
                        })
                    }
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }


    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    return {
        addTable: function () {
            addTable()
            return $this; // Preserve the jQuery chainability 
        },
        removecostumer: function (costumer_seccode) {
            removeCostumer(costumer_seccode)
            return $this; // Preserve the jQuery chainability 
        },

    }
}

