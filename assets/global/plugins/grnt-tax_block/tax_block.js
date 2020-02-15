/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Taxblock {
    constructor(_element, _options) {
        this.elements = _element;
        this.options = _options;
        this.defaults = {
            control_class: "",
            component_name: "",
            multiple: true,
            company_title: false,
            company_title_name: "company_name",
            province: true,
            province_name: "tax_province",
            tax_number: true,
            tax_number_name: "tax_number",
            tax_office_name: "tax_office",
        }
        const template_opt = {
            template_style: "",
            remove_button: false,
        }
        const htmlParts = new html_parts(template_opt);
        //var settings = $.extend({}, defaults, options);
        this.settings = Object.assign({}, this.defaults, this.options)




        var predata = document.querySelectorAll('[data-' + this.settings.component_name + ']');
        let company_name
        let tax_number
        let tax_office_number
        let province
        let office = {};
        let officelist = [];
        for (let i = 0; i < predata.length; i++) {
            if (predata[i].getAttribute("data-company_name") !== null) {
                company_name = predata[i].getAttribute("data-company_name");
            }
            if (predata[i].getAttribute("data-tax_number") !== null) {
                tax_number = predata[i].getAttribute("data-tax_number");
            }

            if (predata[i].getAttribute("data-tax_office") !== null) {
                tax_office_number = predata[i].getAttribute("data-tax_office");
            }

            if (predata[i].getAttribute("data-tax_province") !== null) {
                province = predata[i].getAttribute("data-tax_province");
            }

            if (predata[i].getAttribute("data-tax_office_name") !== null) {
                let office_name = predata[i].getAttribute("data-tax_office_name");
                let office_id = predata[i].getAttribute("data-tax_office_id");
                office = {
                    tax_office_name: office_name,
                    tax_office_id: office_id,
                }
                officelist.push(office)
            }


        }
//        console.log(tax_office_number)
//        console.log(officelist)

        let content = "";
        let random_number;
        if (this.settings.multiple) {
            random_number = Math.floor((Math.random() * 10000) + 1);
        }


        if (this.settings.multiple)
            content += '<input type="hidden" name="' + htmlParts.set_name(this.settings.control_class, "secret_number", random_number, this.settings.condition, this.settings.condition_value) + '" value="' + random_number + '" />';

        if (this.settings.company_title) {
            let col = "", ctinput = "", droptions = "", txoptions = "";
            ctinput = htmlParts.addInput("text", htmlParts.set_name(this.settings.control_class, this.settings.company_title_name, random_number, this.settings.condition, this.settings.condition_value), company_name, "Firma Ünvanını Giriniz", random_number);
            col += htmlParts.addLabel("3", "Firma Ünvanı");
            col += htmlParts.addCol("9", ctinput);

            content += htmlParts.addRow(col, "margin-top-15");
        }

        if (this.settings.province) {
            let col = "", proptions = "", droptions = "", txoptions = "";
            proptions = htmlParts.addOption("---", "Bir il Seçiniz");
            for (let i = 0; i < Object.keys(htmlParts.province_list).length; i++) {
                if (typeof htmlParts.province_list[i] !== "undefined") {
                    if (province != "") {
                        if (province == i) {
                            proptions += htmlParts.addOption(i, htmlParts.province_list[i], true);
                        } else {
                            proptions += htmlParts.addOption(i, htmlParts.province_list[i]);
                        }
                    } else {
                        proptions += htmlParts.addOption(i, htmlParts.province_list[i]);
                    }

                }

            }

            let select = htmlParts.addSelect(proptions, htmlParts.set_name(this.settings.control_class, this.settings.province_name, random_number, this.settings.condition, this.settings.condition_value), "tax_province", random_number);
            col += htmlParts.addLabel("3", "Vergi Dairesi");
            col += htmlParts.addCol("2", select);



            if (officelist.length == 0) {
                txoptions += htmlParts.addOption("---", "Önce İl Seçimini Yapın");
            } else {
                for (let i = 0; i < Object.keys(officelist).length; i++) {
                    if (typeof officelist[i] !== "undefined")
                        if (officelist[i].AAilceNo != 0) {
                            if (tax_office_number == officelist[i].tax_office_id) {

                                txoptions += htmlParts.addOption(officelist[i].tax_office_id, officelist[i].tax_office_name, true);
                            } else {
                                txoptions += htmlParts.addOption(officelist[i].tax_office_id, officelist[i].tax_office_name);
                            }

                        }
                }
            }


            let txselect = htmlParts.addSelect(txoptions, htmlParts.set_name(this.settings.control_class, this.settings.tax_office_name, random_number, this.settings.condition, this.settings.condition_value), "tax_office", random_number);
            col += htmlParts.addCol("2", txselect);

            let txinput = htmlParts.addInput("text", htmlParts.set_name(this.settings.control_class, this.settings.tax_number_name, random_number, this.settings.condition, this.settings.condition_value), tax_number, "vergi Numarası", random_number);
            col += htmlParts.addCol("3", txinput);

            content += htmlParts.addRow(col, "margin-top-15");
        }
        const temp = htmlParts.template(content, random_number);

        this.taxdraw(temp);
    }
    remove_button_event() {
        $('[data-adres="remove"]').on("click", function (e) {
            e.preventDefault();
            var adres_id = $(this).data("adres_id")
            var section_id = $(this).data("section_id")
            if (typeof adres_id !== "undefined") {

            } else {
                $(this).parents("#" + section_id).fadeOut(200, function () {
                    $(this).remove()
                })
            }
        })
    }

    taxdraw(template) {
        if (this.elements !== "undefined") {
            this.elements.innerHTML = template;
            this.taxprovinceChange(this.settings)
        } else {
            console.error("Şirket bilgileri componentinin html alanına ulaşılamıyor. Formda seçili elementin bulunduğuna dikkat edin.")
        }
    }
    taxprovinceChange(settings) {
        document.querySelector('[data-type="tax_province"]').addEventListener("change", function () {
            var province = $(this), select_province_id = province.val(), selected = "", section_id = $(this).data("section_id")
            const options = {component_name: settings.component_name, action: "gettaxdata"}
            $.ajax({type: "post",
                url: component_controller_url(options),
                data: {"select_province_id": select_province_id},
                dataType: "json",
                beforeSend: function (data) {
                    $("body").find(".waiting_screen").fadeIn()
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()
                    if (data.sonuc) {
                        const template_opt = {
                            template_style: "",
                            remove_button: false,
                        }
                        const htmlParts = new html_parts(template_opt);

                        let tax_option = "";
                        tax_option += htmlParts.addOption("---", "Bir İlçe Seçiniz");
                        for (let i = 0; i < Object.keys(data.taxplacelist).length; i++) {
                            if (typeof data.taxplacelist[i] !== "undefined")
                                if (data.taxplacelist[i].AAilceNo != 0) {
                                    tax_option += htmlParts.addOption(data.taxplacelist[i].tax_office_id, data.taxplacelist[i].tax_office_name);
                                }
                        }
                        province.parents("#" + section_id).find('[data-type="tax_office"]').html(tax_option);
                    }
                }
            });
        })
    }
}


/*
 * function () {
 
 }
 */ 