var blkmail = function () {
    var getlistdata = function () {
        $("#getdataforbulkmail").on("click", function (e) {
            e.preventDefault();
            var tablevalue = document.querySelector('[name="customer_table_settings"]').value
            var table_settings = JSON.parse(tablevalue)
            const options = {
                component_name: table_settings.component_name,
                action: "searchdata",
                data: table_settings,
                complete: function (data) {
                    if (data.sonuc) {
                        let bulkmail_data = {}
                        data.result.forEach((item, index) => {
                            let data = {}
                            data = {
                                "name": item.name,
                                "lastname": item.lastname,
                                "id": item.customer_id,
                                "email": item.email,
                                "email_confirm": item.email_cofirm,
                                "public": item.public,
                                "sales": item.sales,
                            }
                            bulkmail_data[index] = (data);
                        })
                        $('[component_name="blkmail"]').prepend('<input type="hidden" name="bulkmail_data" />');
                        document.querySelector('[name="bulkmail_data"]').value = JSON.stringify(bulkmail_data);
                        console.log(bulkmail_data)
                        //$("#bulk_mail_send_form").modal("show")
                        const options = {
                            component_name: "bulk_mail_send_form",
                            component_action: "load",
                            component_object: {"customer_data": bulkmail_data},
                            modal: "#bulk_mail_send_form",
                            starter: "form,component_run"
                        }
                        component_run.run(options)
                    }
                }
            }


            makexhr.send(options)
        })

    }
    return {
        init: function () {
            getlistdata(); // handle adres Blok

        }
    }
}();
jQuery(document).ready(function () {
    blkmail.init(); // init metronic core componets
});
