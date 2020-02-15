/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$.fn.phone_block = function (options) {
    var $this = this;
    var defaults = {
        component_name: "phone_block",
        control_class: "customer_phone_fields",
        phone_type: false,
        phone_type_name: "phone_type",
        area_code: true,
        area_code_name: "area_code",
        phone_number: true,
        phone_number_name: "phone_number",
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
    //console.log(predata)
    if (predata.length != 0) {
        if (!settings.addnew) {
            let dataparameter = "", datavalue = "", income_phone_data = {}
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
                            income_phone_data[dtp[j]] = dtv[j]
                    }
                    //console.log(income_phone_data)
                    const temp = make_content(settings, htmlParts, income_phone_data);
                    draw($this, temp, settings, htmlParts);
                }
            }
        }

    } else {
        const temp = make_content(settings, htmlParts);
        draw($this, temp, settings, htmlParts);
    }



    function make_content(settings, htmlParts, result_data) {
        var phone_code = new Array(
                '0501', '0502', '0503', '0504', '0505', '0506', '0507', '0530',
                '0531', '0532', '0533', '0534', '0535', '0536', '0537', '0538',
                '0539', '0541', '0542', '0543', '0544', '0545', '0546',
                '0549', '0551', '0552', '0553', '0554', '0555', '0556', '0322',
                '0416', '0272', '0472', '0358', '0312', '0242', '0466', '0256',
                '0266', '0228', '0426', '0434', '0374', '0248', '0224', '0286',
                '0376', '0364', '0258', '0412', '0284', '0424', '0446', '0442',
                '0222', '0342', '0454', '0456', '0438', '0326', '0246', '0324',
                '0216', '0212', '0232', '0474', '0366', '0352', '0318', '0386',
                '0348', '0262', '0332', '0274', '0422', '0236', '0344', '0482',
                '0252', '0436', '0384', '0388', '0452', '0464', '0264', '0362',
                '0484', '0368', '0346', '0282', '0356', '0462', '0428', '0414',
                '0276', '0432', '0354', '0372', '0382', '0458', '0338', '0318',
                '0488', '0486', '0378', '0478', '0476', '0226', '0370', '0348',
                '0328', '0380');
        let content = "";
        let random_number = Math.floor((Math.random() * 10000) + 1);
        content += '<input type="hidden" name="' + htmlParts.set_name(settings.control_class, "secret_number", random_number) + '" value="' + random_number + '" />';

        if (typeof result_data !== "undefined") {
            var primary_key = result_data.primary_key;
            content += '<input type="hidden" name="' + htmlParts.set_name(settings.control_class, "primary_key", random_number) + '" value="' + result_data[primary_key] + '" />';
        }
        if (settings.area_code) {
            let col = "", ctoptions = "", tyoptions = "";
            col += htmlParts.addLabel("3", "Telefon Numarası");

            if (settings.phone_type) {
                var phone_type = [
                    {
                        key: "---",
                        text: "Telefon Tipini Seçiniz",
                    },
                    {
                        key: "cell",
                        text: "Cep Telefonu",
                    },
                    {
                        key: "land",
                        text: "Sabit Telefon",
                    }

                ]
                phone_type.forEach(function (currentValue) {
                    if (typeof result_data !== "undefined") {
                        if (result_data.phone_type == currentValue.key) {
                            tyoptions += htmlParts.addOption(currentValue.key, currentValue.text, true);
                        } else {
                            tyoptions += htmlParts.addOption(currentValue.key, currentValue.text);
                        }
                    } else {
                        tyoptions += htmlParts.addOption(currentValue.key, currentValue.text);
                    }

                });
                let tyselect = htmlParts.addSelect(tyoptions, htmlParts.set_name(settings.control_class, settings.phone_type_name, random_number), "phone_type", random_number);
                col += htmlParts.addCol("2", tyselect);
            }


            ctoptions = htmlParts.addOption("---", "Alan Kodu Seçiniz");
            for (let i = 0; i < phone_code.length; i++) {
                if (typeof phone_code[i] !== "undefined") {
                    let number;
                    if (phone_code[i].charAt(0) === '0') {
                        let nbr = phone_code[i].substr(1);
                        number = ("+90" + "(" + nbr + ")");
                    } else {
                        number = phone_code[i];
                    }
                    if (typeof result_data !== "undefined") {
                        if (phone_code[i] == result_data.area_code) {
                            ctoptions += htmlParts.addOption(phone_code[i], number, true);
                        } else {
                            ctoptions += htmlParts.addOption(phone_code[i], number);
                        }
                    } else {
                        ctoptions += htmlParts.addOption(phone_code[i], number);
                    }
                }

            }

            let select = htmlParts.addSelect(ctoptions, htmlParts.set_name(settings.control_class, settings.area_code_name, random_number), "area_code", random_number);
            col += htmlParts.addCol("2", select);
            if (settings.phone_number) {
                var phone_number;
                if (typeof result_data !== "undefined") {
                    phone_number = result_data.phone_number
                } else {
                    phone_number = "";
                }
                let input = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.phone_number_name, random_number), phone_number, "Telefon Numarası");
                col += htmlParts.addCol("3", input);
            }


            content += htmlParts.addRow(col, "margin-top-15");
        }



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
        addnew: function () {
            const temp = make_content(settings, htmlParts);
            draw($this, temp, settings, htmlParts);
        },
        remove: function () {

        }

    }
};







