$.fn.job_table = function (options) {
    var $this = this;
    var defaults = {
        html: false,
        job_seccode: "---",
        product: "all",
        start: 0,
        end: 5,
        show: 5,
        order: "desc",
        adres: false,
        province: 0,
        district: 0,
        neighborhood: 0,
    }
    var settings = $.extend({}, defaults, options);
    console.log(settings)
//    var _start = settings.start,
//            _end = settings.end,
//            _html = settings.html,
//            _show = settings.show,
//            _job_seccodee = settings.job_seccode,
//            _province = settings.province,
//            _district = settings.district,
//            _neighborhood = settings.neighborhood;

    if (settings.html) {
        addTable();
    }


    function addTable() {
        $('[name="table_settings"]').val(JSON.stringify(settings))

        var scriptURL = "/xhr/sendjob/getjobtable";
        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "adres": settings.adres,
                "province": settings.province,
                "district": settings.district,
                "neighborhood": settings.neighborhood,
                "job_seccode": settings.job_seccode,
                "start": settings.start,
                "end": settings.end,
                "show": settings.show,
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
                    $('[data-job="remove_job"]').off()
                    $('[data-job="remove_job"]').on("click", function () {
                        var job_seccode = $(this).data("job_seccode");
                        var btn = $(this);
                        removeJob(job_seccode, btn)
                    }
                    )


                    $('[data-client="edit_client"]').off()
                    $('[data-client="edit_client"]').on("click", function () {
                        var btn = $(this)
                        var job_seccode = btn.data("job_seccode");
                        editJobInfo(job_seccode)
                    }
                    )

                    $('[data-job="confirm"]').off()
                    $('[data-job="confirm"]').on("click", function () {
                        var btn = $(this)
                        var job_seccode = btn.data("job_seccode");
                        jobConfirm(job_seccode, btn)
                    }
                    )

                    $('[data-job="send_cargo"]').off()
                    $('[data-job="send_cargo"]').on("click", function () {
                        var btn = $(this)
                        var job_seccode = btn.data("job_seccode");
                        sendCargo(job_seccode, btn)
                    }
                    )

                    $('[data-job="delivery"]').off()
                    $('[data-job="delivery"]').on("click", function () {
                        var btn = $(this)
                        var job_seccode = btn.data("job_seccode");
                        deliveryCargo(job_seccode, btn)
                    }
                    )


                    $('[data-job="complete"]').off()
                    $('[data-job="complete"]').on("click", function () {
                        var btn = $(this)
                        var job_seccode = btn.data("job_seccode");
                        jobComplete(job_seccode, btn)
                    }
                    )

                    $('[data-job="return_confirm"]').off()
                    $('[data-job="return_confirm"]').on("click", function () {
                        var btn = $(this)
                        var job_seccode = btn.data("job_seccode");
                        returnConfirm(job_seccode, btn)
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

                    $('[data-job="job_detail"]').on("click", function (e) {
                        e.preventDefault();
                        var job_seccode = $(this).data("job_seccode")
                        job_detail(job_seccode)
                    })


                    $('[data-job="get_job_invoice"]').on("click", function (e) {
                        e.preventDefault();
                        var job_seccode = $(this).data("job_seccode")
                        job_invoice(job_seccode)
                    })

                    $('[data-table="show_page"]').off()
                    $('[data-table="show_page"]').on("change", function () {
                        var $this = $(this)
                        page_selected($this)
                    });
                    $('[data-table="show_result"]').off();
                    $('[data-table="show_result"]').on("change", function () {
                        var $this = $(this)
                        show_count($this)
                    });
                    $('[data-table="page_number"]').off()
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
    $('[data-table="show_page"]').off()
    $('[data-table="show_page"]').on("change", function () {
        var $this = $(this)
        page_selected($this)
    });
    $('[data-table="show_result"]').off();
    $('[data-table="show_result"]').on("change", function () {
        var $this = $(this)
        show_count($this)
    });
    $('[data-table="page_number"]').off()
    $('[data-table="page_number"]').on("click", "button", function () {
        var $this = $(this)
        page_number($this)
    })

    $('[data-job="get_job_invoice"]').off()
    $('[data-job="get_job_invoice"]').on("click", function (e) {
        e.preventDefault();
        var job_seccode = $(this).data("job_seccode")
        job_invoice(job_seccode)
    })
    $('[data-job="remove_job"]').off()
    $('[data-job="remove_job"]').on("click", function () {
        var job_seccode = $(this).data("job_seccode");
        var btn = $(this);
        var deleteJob = confirm("İşi Kaldırmak istediğinizden eminmisiniz.?");
        if (deleteJob) {
            removeJob(job_seccode, btn)
        } else {
            toastr["success"]("Tebrikler İşleri Kaldırmayın")
        }

    }
    )


    $('[data-client="edit_client"]').off()
    $('[data-client="edit_client"]').on("click", function () {
        var btn = $(this)
        var job_seccode = btn.data("job_seccode");
        editJobInfo(job_seccode)
    }
    )

    $('[data-job="confirm"]').off()
    $('[data-job="confirm"]').on("click", function () {
        var btn = $(this)
        var job_seccode = btn.data("job_seccode");
        jobConfirm(job_seccode, btn)
    }
    )
//delivery
    $('[data-job="send_cargo"]').off()
    $('[data-job="send_cargo"]').on("click", function () {
        var btn = $(this)
        var job_seccode = btn.data("job_seccode");
        sendCargo(job_seccode, btn)
    }
    )

    $('[data-job="delivery"]').off()
    $('[data-job="delivery"]').on("click", function () {
        var btn = $(this)
        var job_seccode = btn.data("job_seccode");
        deliveryCargo(job_seccode, btn)
    }
    )

    $('[data-job="complete"]').off()
    $('[data-job="complete"]').on("click", function () {
        var btn = $(this)
        var job_seccode = btn.data("job_seccode");
        jobComplete(job_seccode, btn)
    }
    )

    $('[data-job="return_confirm"]').off()
    $('[data-job="return_confirm"]').on("click", function () {
        var btn = $(this)
        var job_seccode = btn.data("job_seccode");
        returnConfirm(job_seccode, btn)
    }
    )

    $('[data-job="job_detail"]').on("click", function (e) {
        e.preventDefault();
        var job_seccode = $(this).data("job_seccode")
        //$('[data-job="get_job_invoice"]')
        $("#job_detail").find('[data-job="get_job_invoice"]').attr("data-job_seccode", job_seccode)
        $("#job_detail").find('[data-job="get_job_invoice"]').html("Faturayı Görüntüle")
        job_detail(job_seccode)
    })


    function page_selected($this) {

        settings.html = true
        let show_count = $('[data-table="show_result"]');
        var page_no = $this.val();

        settings.show = parseInt((show_count.val() === "---" ? 10 : show_count.val()))
        settings.start = (page_no - 1) * settings.show
        settings.end = settings.start + settings.show;
        addTable();
    }

    function page_number($this) {
        let show_count = $('[data-table="show_result"]');
        settings.html = true
        make_selected($this)
        settings.show = parseInt(show_count.val() === "---" ? 10 : show_count.val())
        settings.start = (get_pageno() - 1) * settings.show
        settings.end = parseInt(settings.start) + settings.show;
        addTable();
    }


    function make_selected($this) {
        $('[data-table="page_number"]').find("button").each(function () {
            if ($(this).hasClass("blue")) {
                $(this).removeClass("blue")
            }
        })
        $this.addClass("blue")
    }
    function show_count($this) {

        settings.html = true

        var value = $this.val();
        var page_no = get_pageno();
        settings.show = parseInt((value === "---" ? 10 : value))
        settings.start = (page_no - 1) * settings.show
        settings.end = settings.start + settings.show;

        console.log(settings);
        addTable();
    }

    function get_pageno() {
        let page_no;
        $('[data-table="page_number"]').find("button").each(function () {
            if ($(this).hasClass("blue")) {
                page_no = $(this).data("page")
            }
        })
        return parseInt(page_no);
    }
    function job_invoice(job_seccode) {
        var modal = $("#job_invoice")
        var scriptURL = "/xhr/sendjob/getjobinvoiceinfo";
        $.ajax({type: "post",
            url: scriptURL,
            data: {"job_seccode": job_seccode},
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
                modal.find(".invoice").html("");
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    var invoice_html = set_invoice_html(data);
                    modal.find(".invoice").html(invoice_html)
                    toastr["success"](data.msg)
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    function set_invoice_html(data) {
        //console.log(data)
        var header = "", html = "", customer_info = "", i = 0, table = "", row = "", options_title = "", count = 0, footer = "";
        header = '<div class="row invoice-logo">\n\
                    <div class="col-xs-6 invoice-logo-space">\n\
                        <img src="' + data.site_logo_html + '" alt="Site_logo" />\n\
                    </div>\n\
                    <div class="col-xs-6">\n\
                        <p style="font-size:15px;"> #' + data.job_number + ' / ' + data.date_today + '<span class="muted">İşin Numarası - Bugünün Tarihi </span></p>\n\
                    </div>\n\
                </div>';
        html += header;
        html += "<hr>";
        customer_info = '<div class="row">\n\
                            <div class="col-xs-8">\n\
                                <h4>Sayın:</h4>\n\
                                <ul class="list-unstyled">\n\
                                    <li> ' + data.customer_name + ' </li>\n\
                                    <li> ' + data.customer_adres_description + ' </li>\n\
                                    <li> ' + data.customer_adres_province + ' / ' + data.customer_adres_district + ' / ' + data.customer_adres_neighborhood + '</li>\n\
                                    <li> ' + data.customer_phone + ' </li>\n\
                                </ul>\n\
                            </div>\n\
                        </div>';
        html += customer_info;
        for (i = 0; i < data.job_prodcuts.length; i++) {
            count = i + 1;
            row += '<tr> ';
            row += '<td> ' + count + ' </td>';
            if (data.job_prodcuts[i].product_type == "standart") {
                if (data.job_prodcuts[i].job_price_type == "options") {
                    options_title = '<p>' + data.job_prodcuts[i].job_price_options_title + '</p>';
                } else {
                    options_title = '';
                }
                row += '<td class=""> ' + data.job_prodcuts[i].product_name + ' ' + options_title + '</td>';
            } else if (data.job_prodcuts[i].product_type == "poster") {
                if (data.job_prodcuts[i].job_price_type == "options") {
                    options_title = '<p>' + data.job_prodcuts[i].job_price_options_title + '</p>';
                } else {
                    options_title = '';
                }
                row += '<td class=""> ' + data.job_prodcuts[i].product_name + ' <p>' + data.job_prodcuts[i].width + ' (cm) x ' + data.job_prodcuts[i].height + ' (cm)</p> ' + options_title + '</td>';
            }

            row += '<td class=""> <p>' + data.job_prodcuts[i].product_amount + '</p> </td>';
            row += '<td class=""> <p>' + data.job_prodcuts[i].product_price + ' ' + data.job_prodcuts[i].product_price_unit + '</p> </td>';
            row += '<td class=""> <p>' + data.job_prodcuts[i].product_total + ' ' + data.job_prodcuts[i].product_total_unit + '</p></td>';
            row += '</tr>';
        }


        table = '<div class="row">\n\
                    <div class="col-xs-12">\n\
                        <table class="table table-striped table-hover">\n\
                            <thead>\n\
                                <tr>\n\
                                    <th> # </th>\n\
                                    <th class=""> Açıklama </th>\n\
                                    <th class=""> Adet </th>\n\
                                    <th class=""> Birim Fiyat </th>\n\
                                    <th> Toplam </th>\n\
                                </tr>\n\
                            </thead>\n\
                            <tbody>\n\
                                ' + row + '\n\
                            </tbody>\n\
                        </table>\n\
                    </div>\n\
                </div>';
        html += table;
        footer = ' <div class="row">\n\
                    <div class="col-xs-8">\n\
                        <div class="well">\n\
                            <address>\n\
                                <strong>' + data.site_adres_description + '</strong>\n\
                                <br/> ' + data.site_adres_province + ' / ' + data.site_adres_district + ' / ' + data.site_adres_neighborhood + '\n\
                                <br/>\n\
                                <abbr>Telefon Numarası:</abbr>' + data.site_phone_number + ' \n\
                            </address>\n\
                            <address>\n\
                                <strong>' + data.company_name + '</strong>\n\
                                <br/>\n\
                                <a href="mailto:#"> ' + data.site_general_mail + ' </a>\n\
                                <br/>\n\
                                <strong>VD : ' + data.site_tax_office + '- VN: ' + data.site_tax_number + ' </strong>\n\
                                <br/>\n\
                                <strong>' + data.site_url + ' </strong>\n\
                                <br/>\n\
                            </address>\n\
                        </div>\n\
                    </div>\n\
                    <div class="col-xs-4 invoice-block">\n\
                        <ul class="list-unstyled amounts">\n\
                            <li><p><strong>Toplam Bedel:</strong> ' + data.job_total + ' ' + data.job_unit + '</p></li>\n\
                            <li><p><strong>Kargo Bedeli:</strong> ' + data.job_cargo + ' ' + data.job_unit + '</p></li>\n\
                            <li><p><strong>İndirimler  :</strong>%' + data.job_discount + '</p></li>\n\
                            <li><p><strong>Genel Toplam:</strong> ' + data.job_general_total + ' ' + data.job_unit + '</p></li>\n\
                        </ul>\n\
                        <br/>\n\
                    </div>\n\
                </div>';
        html += footer;
        return html;
    }
    function job_detail(job_seccode) {

        var modal = $("#job_detail")
        var scriptURL = "/xhr/sendjob/getjobdetail";
        $.ajax({type: "post",
            url: scriptURL,
            data: {"job_seccode": job_seccode},
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
                modal.find('[data-job]').each(function () {
                    $(this).html("")
                })
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    modal.find('[data-job="job_status"]').html(data.job_status)

                    modal.find('[data-job="customer_name"]').html(data.customer_name)
                    modal.find('[data-job="customer_email"]').html(data.customer_email)
                    modal.find('[data-job="customer_shipping_adres"]').html(data.customer_shipping_adres)
                    modal.find('[data-job="customer_billing_adres"]').html(data.customer_billing_adres)
                    modal.find('[data-job="customer_phone"]').html(data.customer_phone)
                    modal.find('[data-job="customer_payment_method"]').html(data.customer_payment_method)
                    modal.find('[data-job="customer_connection_ip"]').html(data.customer_connection_ip)
                    modal.find('[data-job="start_date"]').html(data.start_date)
                    modal.find('[data-job="end_date"]').html(data.end_date)
                    modal.find('[data-job="customer_payment_rate"]').html(data.customer_payment_rate)
                    modal.find('[data-job="job_confirm_time"]').html(data.job_confirm_time)
                    modal.find('[data-job="job_complete_time"]').html(data.job_complete_time)
                    modal.find('[data-job="job_price"]').html(data.job_price + ' ' + data.unit)
                    modal.find('[data-job="job_cargo"]').html(data.job_cargo + ' ' + data.unit)
                    modal.find('[data-job="job_extra"]').html(data.job_extra + ' ' + data.unit)
                    modal.find('[data-job="job_tax"]').html(data.job_tax + ' ' + data.unit)
                    modal.find('[data-job="job_discount"]').html(data.job_discount + ' ' + data.unit)
                    modal.find('[data-job="job_total"]').html(data.job_total + ' ' + data.unit)

                    $("#injob_product_table").job_product_table({
                        "html": true,
                        "job_seccode": job_seccode
                    });
                    toastr["success"](data.msg)
                } else {

                    toastr["error"](data.msg)
                }
            }
        });
    }
    function jobConfirm(job_seccode, btn) {

        var scriptURL = "/xhr/sendjob/jobconfirm";
        $.ajax({type: "post",
            url: scriptURL,
            data: {"job_seccode": job_seccode},
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    /*RESET*/
                    if (typeof btn !== "undefined") {
                        btn.parent().html('<button class="btn" data-job="send_cargo" data-job_seccode="' + job_seccode + '">Kargoya Verildi</button>')
                        $('[data-job="send_cargo"]').off()
                        $('[data-job="send_cargo"]').on("click", function () {
                            var btn = $(this)
                            var job_seccode = btn.data("job_seccode");
                            sendCargo(job_seccode, btn)
                        }
                        )
                    }
                    toastr["success"](data.msg)
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    function sendCargo(job_seccode, btn) {

        var scriptURL = "/xhr/sendjob/sendcargo";
        $.ajax({type: "post",
            url: scriptURL,
            data: {"job_seccode": job_seccode},
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    /*RESET*/
                    if (typeof btn !== "undefined") {
                        btn.parent().html('<button class="btn" data-job="delivery" data-job_seccode="' + job_seccode + '">Kargo Teslim Edildi</button>')
                        $('[data-job="delivery"]').off()
                        $('[data-job="delivery"]').on("click", function () {
                            var btn = $(this)
                            var job_seccode = btn.data("job_seccode");
                            deliveryCargo(job_seccode, btn)
                        }
                        )
                    }
                    toastr["success"](data.msg)
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    function deliveryCargo(job_seccode, btn) {

        var scriptURL = "/xhr/sendjob/deliverycargo";
        $.ajax({type: "post",
            url: scriptURL,
            data: {"job_seccode": job_seccode},
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    /*RESET*/
                    if (typeof btn !== "undefined") {
                        btn.parent().html('<button class="btn" data-job="complete" data-job_seccode="' + job_seccode + '">Tamamla</button>')
                        $('[data-job="complete"]').off()
                        $('[data-job="complete"]').on("click", function () {
                            var btn = $(this)
                            var job_seccode = btn.data("job_seccode");
                            jobComplete(job_seccode, btn)
                        }
                        )
                    }
                    toastr["success"](data.msg)
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    function returnConfirm(job_seccode, btn) {

        var scriptURL = "/xhr/sendjob/returnjobconfirm";
        $.ajax({type: "post",
            url: scriptURL,
            data: {"job_seccode": job_seccode},
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    /*RESET*/
                    if (typeof btn !== "undefined") {
                        btn.parent().html('<button class="btn">Teslim Edildi</button>')
                    }
                    toastr["success"](data.msg)
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    function jobComplete(job_seccode, btn) {

        var scriptURL = "/xhr/sendjob/jobcomplete";
        $.ajax({type: "post",
            url: scriptURL,
            data: {"job_seccode": job_seccode},
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    /*RESET*/
                    if (typeof btn !== "undefined") {
                        btn.parent().html('<button class="btn">Teslim Edildi</button>')
                    }
                    toastr["success"](data.msg)
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    function editJobInfo(job_seccode) {
        var scriptURL = "/xhr/sendjob/getjobinfo";
        var form = $('[data-form="xhr"]');
        $.ajax({type: "post",
            url: scriptURL,
            data: {"job_seccode": job_seccode},
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    /*RESET*/
                    form.find('[name="job_seccode"]').remove()
                    form.find('[name="customer_fullname"]').val("")

                    /*RESET*/


                    form.attr("action", "/xhr/sendjob/editjob");
                    form.prepend('<input type="hidden" name="job_seccode" value="' + job_seccode + '" >')

                    form.find('[name="customer_fullname"]').val(data.client_name)

                    toastr["success"](data.msg)
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }


    function removeJob(job_seccode, btn) {

        var scriptURL = "/xhr/sendjob/removejob";
        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "job_seccode": job_seccode,
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
                            var checkbox_job_seccode = checkbox.data("job_seccode")
                            if (checkbox_job_seccode == job_seccode) {
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
        removejob: function (job_seccode) {
            removeJob(job_seccode)
            return $this; // Preserve the jQuery chainability 
        },
    }
}

