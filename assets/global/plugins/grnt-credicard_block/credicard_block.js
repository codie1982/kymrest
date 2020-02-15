/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$.fn.credicard_block = function (options) {
    var $this = this;
    var defaults = {
        component_name: "credicard_block",
        control_class: "customer_credicard_fields",
        title_name: "credicard_title",
        month_name: "month",
        year_name: "year",
        credicard_name: "credi_card_number",
        security_name: "card_security_number",
        addnew: false,
    }



    var settings = $.extend({}, defaults, options);
    const template_opt = {
        template_style: "background:#f5f5f5;border:1px solid #e1e1e1",
        remove_button: true,
    }
    const htmlParts = new html_parts(template_opt);


    var getValue = [];
    var predata = document.querySelectorAll('[data-' + settings.component_name + ']');
    if (!settings.addnew) {
        if (predata.length != 0) {
            let dataparameter = "", datavalue = "", income_cc_data = {}
            for (let i = 0; i < predata.length; i++) {
                if (predata[i].getAttribute("data-parameter") !== null) {
                    let nm = [];
                    dataparameter = predata[i].getAttribute("data-parameter");
                    datavalue = predata[i].getAttribute("data-value");
                    let dtp = dataparameter.split(",");
                    let dtv = datavalue.split(",");
                    let count = dataparameter.length
                    for (let j = 0; j < count; j++) {
                        if (typeof dtp[j] !== "undefined")
                            income_cc_data[dtp[j]] = dtv[j]
                    }
                    const temp = make_content(settings, htmlParts, income_cc_data);
                    draw($this, temp, settings, htmlParts);
                }

            }
        } else {
            const temp = make_content(settings, htmlParts);
            draw($this, temp, settings, htmlParts);
        }
    }

    function make_content(settings, htmlParts, result_data) {
        let content = "", ttinput = "";
        let random_number = Math.floor((Math.random() * 10000) + 1);
        content += '<input type="hidden" name="' + htmlParts.set_name(settings.control_class, "secret_number", random_number) + '" value="' + random_number + '" />';

        if (typeof result_data !== "undefined") {
            var primary_key = result_data.primary_key;
            content += '<input type="hidden" name="' + htmlParts.set_name(settings.control_class, "primary_key", random_number) + '" value="' + result_data[primary_key] + '" />';
        }

        let col = "", mntoptions = "", yroptions = "", crinput = "", scinput = "";
        col += htmlParts.addLabel("3", "Kredi Kart Sahibi");

        if (typeof result_data !== "undefined") {
            ttinput = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.title_name, random_number), result_data.credicard_title, "Kredi Kart Sahibi");
        } else {
            ttinput = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.title_name, random_number), "", "Kredi Kart Sahibi");
        }


        col += htmlParts.addCol("9", ttinput);
        content += htmlParts.addRow(col, "margin-top-15");

        col = "";
        col += htmlParts.addLabel("3", "Kredi Kartı Numarası");

        mntoptions = htmlParts.addOption("---", "Ay Seçin");
        for (let i = 1; i <= 12; i++) {
            if (typeof result_data !== "undefined") {
                if (result_data.month == i) {
                    mntoptions += htmlParts.addOption(i, i, true);
                } else {
                    mntoptions += htmlParts.addOption(i, i);
                }


            } else {
                mntoptions += htmlParts.addOption(i, i);

            }
        }

        let mnselect = htmlParts.addSelect(mntoptions, htmlParts.set_name(settings.control_class, settings.month_name, random_number), "month", random_number);

        col += htmlParts.addCol("2", mnselect);

        var d = new Date();
        var current_year = d.getFullYear();
        yroptions = htmlParts.addOption("---", "Yıl Seçiniz");
        for (let i = 0; i < 10; i++) {
            let cr = current_year + i;
            if (typeof result_data !== "undefined") {
                if (result_data.year == cr) {
                    yroptions += htmlParts.addOption(cr, cr, true);
                } else {
                    yroptions += htmlParts.addOption(cr, cr);
                }
            } else {

                yroptions += htmlParts.addOption(cr, cr);
            }

        }

        let select = htmlParts.addSelect(yroptions, htmlParts.set_name(settings.control_class, settings.year_name, random_number), "year", random_number);
        col += htmlParts.addCol("2", select);
        if (typeof result_data !== "undefined") {
            crinput = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.credicard_name, random_number), result_data.credi_card_number, "Kart Numarası");
        } else {
            crinput = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.credicard_name, random_number), "", "Kart Numarası");
        }

        col += htmlParts.addCol("3", crinput);
        if (typeof result_data !== "undefined") {
            scinput = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.security_name, random_number), result_data.card_security_number, "Güvenlik Numarası");
        } else {
            scinput = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.security_name, random_number), "", "Güvenlik Numarası");
        }

        col += htmlParts.addCol("2", scinput);
        content += htmlParts.addRow(col, "margin-top-15");

        if (typeof result_data !== "undefined") {
            var primary_key = result_data.primary_key;

            return htmlParts.template(content, random_number, settings.component_name, result_data[primary_key]);
        } else {
            return htmlParts.template(content, random_number, settings.component_name);
        }
    }

    function draw($this, template, settings, htmlParts) {
        $this.append(template)
        htmlParts.remove_button_event(settings.component_name)
    }
    return {
        add: () => {
            const temp = make_content(settings, htmlParts);
            draw($this, temp, settings, htmlParts);
        }
    }
};







