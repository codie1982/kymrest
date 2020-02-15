/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$.fn.adres_block = function (options) {
    var $this = this;
    var defaults = {
        control_class: "",
        title: true,
        title_name: "title_name",
        province: true,
        province_name: "province",
        district: true,
        district_name: "district",
        neighborhood: true,
        neighborhood_name: "neighborhood",
        street: true,
        street_name: "street",
        mail_code: true,
        mail_code_name: "mail_code",
        directions: true,
        directions_name: "directions",
        description: true,
        description_name: "description",
        addnew: false,
    }



    const template_opt = {
        template_style: "background:#f5f5f5;border:1px solid #e1e1e1",
        remove_button: true,
    }
    const htmlParts = new html_parts(template_opt);
    var settings = $.extend({}, defaults, options);
    var getValue = [];

    var predata = document.querySelectorAll('[data-' + settings.component_name + ']');

    if (predata.length != 0) {
        if (!settings.addnew) {
            let dataparameter = "", datavalue = "", income_adres_data = {}, datadistrictlist, dataneighborhood_list, dataneighborhoodsmt_list, parameter = [], value = [];
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
                            income_adres_data[dtp[j]] = dtv[j]
                    }

                    income_adres_data.districtlist = JSON.parse(atob(predata[i].getAttribute("data-district_list")));
                    income_adres_data.AAmhlKoyAdi = JSON.parse(atob(predata[i].getAttribute("data-neighborhood_list")));
                    income_adres_data.AASmtBckAdi = JSON.parse(atob(predata[i].getAttribute("data-neighborhoodsmt_list")))


                    //console.log(income_adres_data)
                    const temp = make_content(settings, htmlParts, income_adres_data);
                    draw($this, temp, settings, htmlParts);
                }
            }
        }

    } else {

        const temp = make_content(settings, htmlParts);
        draw($this, temp, settings, htmlParts);
    }

    function make_content(settings, htmlParts, result_data) {

        let content = "";
        let random_number = Math.floor((Math.random() * 10000) + 1);
        content += '<input type="hidden" name="' + htmlParts.set_name(settings.control_class, "secret_number", random_number) + '" value="' + random_number + '" />';
        if (typeof result_data !== "undefined") {
            var primary_key = result_data.primary_key;
            content += '<input type="hidden" name="' + htmlParts.set_name(settings.control_class, "primary_key", random_number) + '" value="' + result_data[primary_key] + '" />';
        }

        if (settings.title) {
            content += add_title(settings, random_number, htmlParts, result_data);
        }

        if (settings.province) {
            let col = "", proptions = "", droptions = "", nhoptions = "";
            proptions = htmlParts.addOption("---", "Bir il Seçiniz");
            for (let i = 0; i < Object.keys(htmlParts.province_list).length; i++) {
                if (typeof htmlParts.province_list[i] !== "undefined") {
                    if (typeof result_data !== "undefined") {
                        if (result_data.province == i) {
                            proptions += htmlParts.addOption(i, htmlParts.province_list[i], true);
                        } else {
                            proptions += htmlParts.addOption(i, htmlParts.province_list[i]);
                        }
                    } else {
                        proptions += htmlParts.addOption(i, htmlParts.province_list[i]);
                    }
                }
            }
            let select = htmlParts.addSelect(proptions, htmlParts.set_name(settings.control_class, settings.province_name, random_number), "province", random_number);
            col += htmlParts.addLabel("3", "İl");
            col += htmlParts.addCol("2", select);
            if (settings.district) {


                if (typeof result_data !== "undefined") {
                    droptions += districtopt(result_data, result_data.district)
                } else {
                    droptions += htmlParts.addOption("---", "Önce İl Seçimini Yapın");
                }
                let drselect = htmlParts.addSelect(droptions, htmlParts.set_name(settings.control_class, settings.district_name, random_number), "district", random_number);
                col += htmlParts.addLabel("1", "İlçe");
                col += htmlParts.addCol("2", drselect);
            }

            if (settings.neighborhood) {

                if (typeof result_data !== "undefined") {
                    nhoptions += neighborhoodopt(result_data, result_data.neighborhood)
                } else {
                    nhoptions += htmlParts.addOption("---", "Önce İl Seçimini Yapın");
                }
                let nhselect = htmlParts.addSelect(nhoptions, htmlParts.set_name(settings.control_class, settings.neighborhood_name, random_number), "neighborhood", random_number);
                col += htmlParts.addLabel("1", "Mahalle");
                col += htmlParts.addCol("2", nhselect);
            }
            content += htmlParts.addRow(col, "margin-top-15");
            if (settings.street) {
                let col = "", input = "";
                if (typeof result_data !== "undefined") {
                    input = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.street_name, random_number), result_data.street, "Sokak Numarası");
                } else {
                    input = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.street_name, random_number), "", "Sokak Numarası");
                }

                col += htmlParts.addLabel("3", "Sokak Numarası");
                col += htmlParts.addCol("3", input);
                content += htmlParts.addRow(col, "margin-top-15");
            }


            if (settings.mail_code) {
                let col = "", input = "";
                if (typeof result_data !== "undefined") {
                    input = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.mail_code_name, random_number), result_data.mail_code, "Posta Kodu");
                } else {
                    input = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.mail_code_name, random_number), "", "Posta Kodu");
                }

                col += htmlParts.addLabel("3", "Posta Kodu");
                col += htmlParts.addCol("3", input);
                content += htmlParts.addRow(col, "margin-top-15");
            }
        }

        if (settings.directions) {
            let col = "", input = "";
            if (typeof result_data !== "undefined") {
                input = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.directions_name, random_number), result_data.directions, "Adres Tarifi");
            } else {
                input = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.directions_name, random_number), "", "Adres Tarifi");
            }

            col += htmlParts.addLabel("3", "Adres Tarifi");
            col += htmlParts.addCol("9", input);
            content += htmlParts.addRow(col, "margin-top-15");
        }

        if (settings.description) {
            let col = "", input = "";
            if (typeof result_data !== "undefined") {
                input = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.description_name, random_number), result_data.description, "Adres Açıklaması");
            } else {
                input = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.description_name, random_number), "", "Adres Açıklaması");
            }

            col += htmlParts.addLabel("3", "Adres Açıklaması");
            col += htmlParts.addCol("9", input);
            content += htmlParts.addRow(col, "margin-top-15");
        }
        if (typeof result_data !== "undefined") {
            var primary_key = result_data.primary_key;
            return htmlParts.template(content, random_number, settings.component_name, result_data[primary_key]);
        } else {
            return htmlParts.template(content, random_number, settings.component_name);
        }
    }

    function add_title(settings, random, htmlParts, data) {
        let col = "", input = "";
        if (typeof data !== "undefined") {
            input = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.title_name, random), data.adres_title, "Ev adresi");
        } else {
            input = htmlParts.addInput("text", htmlParts.set_name(settings.control_class, settings.title_name, random), "", "Ev adresi");
        }

        col += htmlParts.addLabel("3", "Adres Başlığı");
        col += htmlParts.addCol("9", input);
        return htmlParts.addRow(col, "margin-top-15");
    }

    function draw($this, template, settings, htmlParts) {
        $this.append(template)
        htmlParts.remove_button_event()
        provinceChange(settings)
        districtChange(settings)
    }

    function provinceChange(settings) {
        $('[data-type="province"]').off()
        $('[data-type="province"]').on("change", async function () {
            const template_opt = {
                template_style: "background:#f5f5f5;border:1px solid #e1e1e1",
                remove_button: true,
            }
            const htmlParts = new html_parts(template_opt);
            var province = $(this), select_province_id = province.val(), selected = "", section_id = $(this).data("section_id")
            const district_option = await get_district(select_province_id);
            province.parents("#" + section_id).find('[data-type="district"]').html(district_option);
            province.parents("#" + section_id).find('[data-type="neighborhood"]').html(htmlParts.addOption("---", "Bir İlçe Seçiniz"));
        })
    }

    function districtChange() {
        $('[data-type="district"]').off()
        $('[data-type="district"]').on("change", async function () {
            const template_opt = {
                template_style: "background:#f5f5f5;border:1px solid #e1e1e1",
                remove_button: true,
            }
            const htmlParts = new html_parts(template_opt);
            var district = $(this),
                    section_id = district.data("section_id"),
                    select_province_id = district.parents("#" + section_id).find('[data-type="province"]').children("option:selected").val(),
                    select_district_id = district.val();
            const neighborhood_list = await get_neighborhood(select_province_id, select_district_id)
            district.parents("#" + section_id).find('[data-type="neighborhood"]').html(neighborhood_list);
        })
    }

    function get_district(select_province_id) {
        return new Promise(resolve => {
            const  options = {component_name: settings.component_name, action: "getdistrictdata"}
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
                        resolve(districtopt(data));
                    }
                }
            });
            //  
        });
    }
    function get_neighborhood(select_province_id, select_district_id) {
        return new Promise(resolve => {
            const  options = {component_name: settings.component_name, action: "getneighborhooddata"}
            $.ajax({type: "post",
                url: component_controller_url(options),
                data: {"select_province_id": select_province_id, "select_district_id": select_district_id},
                dataType: "json",
                beforeSend: function (data) {
                    $("body").find(".waiting_screen").fadeIn()
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()
                    if (data.sonuc) {
                        resolve(neighborhoodopt(data));
                    }
                }
            });
        })
    }


    function districtopt(data, selected) {

        let district_option = "";
        district_option += htmlParts.addOption("---", "Bir İlçe Seçiniz");
        for (let i = 0; i < Object.keys(data.districtlist).length; i++) {
            if (typeof data.districtlist[i] !== "undefined")
                if (data.districtlist[i].AAilceNo != 0) {
                    if (selected == data.districtlist[i].AAilceNo) {
                        district_option += htmlParts.addOption(data.districtlist[i].AAilceNo, data.districtlist[i].AAilceAdi, true);
                    } else {
                        district_option += htmlParts.addOption(data.districtlist[i].AAilceNo, data.districtlist[i].AAilceAdi);
                    }

                }
        }
        return district_option
    }
    function neighborhoodopt(data, selected) {
        var neighborhoodlist_temp = "";
        neighborhoodlist_temp = htmlParts.addOption("---", "Bir Semt Seçiniz Seçiniz");
        for (let i = 1; i < Object.keys(data.AASmtBckAdi).length; i++) {
            var lastSemt = data.AASmtBckAdi[i].AASmtBckAdi
            var _lastSemt = htmlParts.myTrim(lastSemt)
            neighborhoodlist_temp += ' <optgroup label="' + htmlParts.myTrim(data.AASmtBckAdi[i].AASmtBckAdi) + '">';
            for (let j = 1; j < Object.keys(data.AAmhlKoyAdi).length; j++) {
                var _AASmtBckAdi = htmlParts.myTrim(data.AAmhlKoyAdi[j].AASmtBckAdi);
                if (_lastSemt === _AASmtBckAdi) {
                    var trim_AAmhlKoyAdi = htmlParts.myTrim(data.AAmhlKoyAdi[j].AAmhlKoyAdi);
                    if (trim_AAmhlKoyAdi != "") {
                        if (selected == data.AAmhlKoyAdi[j].adres_id) {
                            neighborhoodlist_temp += htmlParts.addOption(data.AAmhlKoyAdi[j].adres_id, trim_AAmhlKoyAdi, true);
                        } else {
                            neighborhoodlist_temp += htmlParts.addOption(data.AAmhlKoyAdi[j].adres_id, trim_AAmhlKoyAdi);
                        }
                    }
                }
            }
            neighborhoodlist_temp += ' </optgroup>';
        }

        return neighborhoodlist_temp;
    }


    return {
        addnew: function () {
            const temp = make_content(settings, htmlParts);
            draw($this, temp, settings, htmlParts);
        }
    }

};












