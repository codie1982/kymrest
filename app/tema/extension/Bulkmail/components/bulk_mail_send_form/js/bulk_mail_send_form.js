/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var bulk_mail_send_form = function () {

    var send_bulk_mail = function () {
        $("#send_bulk_mail").on("click", (e) => {
            e.preventDefault()
            const customer_data_string = document.querySelector('[name="bulkmail_data"]').value
            const customer_data = JSON.parse(customer_data_string);
            const mail_subject_select = document.getElementById("bulk_mail_type")
            const mail_subject = mail_subject_select.options[mail_subject_select.selectedIndex].value

            if (mail_subject !== "---") {
                let bl = {}
                let bldata = {}
                for (let i = 0; i < Object.keys(customer_data).length; i++) {
                    bl = {
                        "name": customer_data[i].name,
                        "lastname": customer_data[i].lastname,
                        "mail": customer_data[i].email,
                        "id": customer_data[i].id,
                        "mail_subject": mail_subject,
                    }
                    bldata[i] = bl
                }


                const options = {
                    "component_name": "bulk_mail_send_form",
                    "component_action": "add_bulkmail",
                    "component_object": {"bulkdata": bldata}
                }
                component_run.run(options)
            } else {
                alert("Bir Mail sınıfı Seçin")
            }

        })
    }
    return {
        init: function () {
            send_bulk_mail();
        }
    }
}();
jQuery(document).ready(function () {
    bulk_mail_send_form.init(); // init metronic core componets
});