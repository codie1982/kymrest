/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$.fn.makeForm = function (options) {
    var $this = this;
    var defaults = {
        component_name: "",
        secret_number: true,
        formGroup: false,
        rowClass: false,
        list: false,
        liclass: false,
        templateStyle: [],
        content: [],
        province_event: false,
        district_event: false,
        neighborhood_event: false,
        taxoffice_event: false,
        form_complete: function () {}
    }


    let section_id = Math.floor((Math.random() * 10000) + 1);
    var starter_component = [];
    var settings = $.extend({}, defaults, options);
    const htmlParts = new html_parts(section_id, {addlist: settings.list, liclass: settings.liclass});
    make_content(htmlParts);
    // draw($this, temp, settings, htmlParts);

    function make_content(htmlParts) {
        let content_plan = settings.content;
        let ctemplate = $('[component_name="' + settings.component_name + '"]').find('[data-template]')

        if (typeof settings.max_count !== "undefined") {
            if (settings.max_count > ctemplate.length) {
                if (content_plan !== null) {
                    for (let i = 0; i < content_plan.length; i++) {
                        let template = makeContent(content_plan[i], htmlParts)
                        draw($this, template, htmlParts);
                    }
                }
            } else {
                alert("En Fazla <>" + settings.max_count + "<> adet alan oluşturabilirsiniz");
            }
        } else {
            if (content_plan !== null) {
                for (let i = 0; i < content_plan.length; i++) {
                    let template = makeContent(content_plan[i], htmlParts)
                    draw($this, template, htmlParts);
                }
            }
        }
    }


    function makeContent(content_plan, htmlParts) {
        let row = "", col = "", li = "";
        let secret_number = null;
        if (settings.secret_number) {
            secret_number = Math.floor((Math.random() * 10000) + 1)
        }
        for (let i = 0; i < content_plan.length; i++) {
            col = "";

            for (let j = 0; j < content_plan[i].length; j++) {
                let inside = "";
                let cnt = content_plan[i][j].content;

                switch (cnt.type) {
                    case "primary_key":
                        col += htmlParts.primary_key(cnt.control_class, cnt.primary_id, secret_number);
                        break;
                    case "secret_number":
                        col += htmlParts.secretNumber(cnt.control_class, secret_number);
                        break;
                    case "label":
                        col += htmlParts.addLabel(content_plan[i][j].col[0], cnt.text)
                        break;
                    case "phone_block":
                        col += htmlParts.addPhoneList(content_plan[i][j].col[0], htmlParts.set_name(cnt.control_class, cnt.action, secret_number, cnt.contidion, cnt.contidion_value), cnt.attributes, cnt.selected_value)
                        break;
                    case "province":
                        settings.province_event = true
                        col += htmlParts.addProvince(content_plan[i][j].col[0], htmlParts.set_name(cnt.control_class, cnt.action, secret_number, cnt.contidion, cnt.contidion_value), cnt.attributes, cnt.selected_value)
                        break;
                    case "district":
                        settings.district_event = true
                        let dslist = "";
                        if (typeof cnt.district_list !== "undefined") {
                            dslist = JSON.parse(atob(cnt.district_list));
                        } else {
                            dslist = null;
                        }
                        col += htmlParts.addDistrict(content_plan[i][j].col[0], htmlParts.set_name(cnt.control_class, cnt.action, secret_number, cnt.contidion, cnt.contidion_value), cnt.attributes, cnt.selected_value, dslist)
                        break;
                    case "neighborhood":
                        settings.neighborhood_event = true
                        let nblist = "", nbsmlist = "";
                        if (typeof cnt.neighborhood_list !== "undefined") {
                            nblist = JSON.parse(atob(cnt.neighborhood_list));
                            nbsmlist = JSON.parse(atob(cnt.neighborhood_semtlist));
                        } else {
                            nblist = null;
                            nbsmlist = null;
                        }
                        col += htmlParts.addNeighborhood(content_plan[i][j].col[0], htmlParts.set_name(cnt.control_class, cnt.action, secret_number, cnt.contidion, cnt.contidion_value), cnt.attributes, cnt.selected_value, nblist, nbsmlist)
                        break;


                    case "tax_office":
                        settings.taxoffice_event = true
                        let txlist = "";
                        if (typeof cnt.tax_office_list !== "undefined") {
                            txlist = JSON.parse(atob(cnt.tax_office_list));
                        } else {
                            txlist = null;
                        }
                        settings.taxoffice_event =
                                col += htmlParts.addTaxOffice(content_plan[i][j].col[0], htmlParts.set_name(cnt.control_class, cnt.action, secret_number, cnt.contidion, cnt.contidion_value), cnt.attributes, cnt.selected_value, txlist)
                        break;
                    case "profession":
                        col += htmlParts.addProfession(content_plan[i][j].col[0], htmlParts.set_name(cnt.control_class, cnt.action, secret_number, cnt.contidion, cnt.contidion_value), cnt.attributes, cnt.selected_value)
                        break;
                    case "input":
                        inside = htmlParts.addInput(htmlParts.set_name(cnt.control_class, cnt.action, secret_number, cnt.contidion, cnt.contidion_value), cnt.attributes)
                        col += htmlParts.addCol(content_plan[i][j].col[0], inside);
                        break;
                    case "select":
                        let options = "";
                        if (cnt.options != null) {
                            for (let c = 0; c < cnt.options.length; c++) {
                                options += htmlParts.addOptionbyAttributes(cnt.options[c].attributes, cnt.options[c].text);
                            }
                            inside = htmlParts.addSelect(options, htmlParts.set_name(cnt.control_class, cnt.action, secret_number, cnt.contidion, cnt.contidion_value), cnt.attributes)
                        }
                        col += htmlParts.addCol(content_plan[i][j].col[0], inside);
                        break;
                    case "checkbox":
                        let checkbox = "";
                        checkbox += htmlParts.addCheckItem(cnt.check["attributes"], htmlParts.set_name(cnt.control_class, cnt.action, secret_number, cnt.contidion, cnt.contidion_value), cnt.check["text"])
                        inside = htmlParts.addCheckCover(checkbox, cnt.attributes)
                        col += htmlParts.addCol(content_plan[i][j].col[0], inside);
                        break;
                    case "radiobox":
                        let radiobox = "";
                        for (let i = 0; i < Object.keys(cnt.radio).length; i++) {
                            radiobox += htmlParts.addRadioItem(cnt.radio[i].attributes, htmlParts.set_name(cnt.control_class, cnt.action, secret_number, cnt.contidion, cnt.contidion_value), cnt.radio[i].text)
                        }

                        inside = htmlParts.addRadioCover(radiobox, cnt.attributes)
                        col += htmlParts.addCol(content_plan[i][j].col[0], inside);
                        break;
                    case "textarea":
                        inside = htmlParts.addTextarea(htmlParts.set_name(cnt.control_class, cnt.action, secret_number, cnt.contidion, cnt.contidion_value), cnt.text, cnt.attributes)
                        col += htmlParts.addCol(content_plan[i][j].col[0], inside);
                        break;
                    case "offset":
                        col += htmlParts.addCol(content_plan[i][j].col[0], "");
                        break;
                    case "div":
                        col += htmlParts.addDiv(cnt.attributes, cnt.html);
                        break;
                    case "component":
                        starter_component.push(cnt.component_name)
                        col += htmlParts.addCol(content_plan[i][j].col[0], cnt.content);
                        break;
                    case "removeButton":
                        col += htmlParts.removeButton(settings.component_name, cnt.key);
                        break;
                }
            }

            row += htmlParts.addRow(col, settings.rowClass, settings.formGroup)

        }
        return htmlParts.template(row, settings.templateStyle);
    }


    function draw($this, template, htmlParts) {
        $this.append(template)
        settings.form_complete()
        htmlParts.remove_button_event()



        if (settings.province_event) {
            provinceChange(settings)
        }

        if (settings.district_event) {
            districtChange(settings)
        }

        if (settings.taxoffice_event) {
            taxOfficeChange(settings)
        }



        if (!starter_component.length) {
            for (let i = 0; i < starter_component.length; i++) {
                let starter = starter_component[i] + '.init()';
                eval(starter)
            }
        }
    }

    function taxOfficeChange() {
        $('[data-type="tax_province"]').off()
        $('[data-type="tax_province"]').on("change", async function () {
            const htmlParts = new html_parts();
            var province = $(this), select_province_id = province.val(), selected = "", section_id = $(this).data("section_id")
            const taxOffice_option = await get_taxOffice_list(select_province_id);
            province.parents("#" + section_id).find('[data-type="tax_office"]').html(taxOffice_option);
        })
    }

    function provinceChange() {
        $('[data-type="province"]').off()
        $('[data-type="province"]').on("change", async function () {

            const htmlParts = new html_parts();
            var province = $(this), select_province_id = province.val(), selected = "", section_id = $(this).data("section_id"), component_name = $(this).data("component_name")
            const district_option = await get_district(select_province_id, component_name);
            province.parents("#" + section_id).find('[data-type="district"]').html(district_option);
            province.parents("#" + section_id).find('[data-type="neighborhood"]').html(htmlParts.addOption("---", "Bir İlçe Seçiniz"));
        })
    }

    function districtChange() {
        $('[data-type="district"]').off()
        $('[data-type="district"]').on("change", async function () {
            const htmlParts = new html_parts();
            var district = $(this),
                    section_id = district.data("section_id"),
                    select_province_id = district.parents("#" + section_id).find('[data-type="province"]').children("option:selected").val(),
                    select_district_id = district.val();
            const neighborhood_list = await get_neighborhood(select_province_id, select_district_id)
            district.parents("#" + section_id).find('[data-type="neighborhood"]').html(neighborhood_list);
        })
    }

    function get_taxOffice_list(select_province_id) {
        return new Promise(resolve => {
            const  options = {component_name: settings.component_name, action: "gettaxdata"}
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
                        resolve(taxOfficeopt(data));
                    }
                }
            });
            //  
        });
    }

    function taxOfficeopt(data, selected) {
        let options = "";
        options += htmlParts.addOption("---", "Bir İl Seçiniz");
        for (let i = 0; i < Object.keys(data.taxplacelist).length; i++) {
            if (typeof data.taxplacelist[i] !== "undefined")
                if (data.taxplacelist[i].tax_office_id != 0) {
                    if (selected == data.taxplacelist[i].tax_office_id) {
                        options += htmlParts.addOption(data.taxplacelist[i].tax_office_id, data.taxplacelist[i].tax_office_name, true);
                    } else {
                        options += htmlParts.addOption(data.taxplacelist[i].tax_office_id, data.taxplacelist[i].tax_office_name);
                    }

                }
        }
        return options
    }

    function get_district(select_province_id, component_name) {
        return new Promise(resolve => {
            const  options = {component_name: component_name, action: "getdistrictdata"}
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

        }
    }

};












