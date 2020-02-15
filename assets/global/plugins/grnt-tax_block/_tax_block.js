/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$.fn.tax_block = function (options) {

    var $this = this;
    var defaults = {
        control_class: "",
        component_name: "",
        province: true,
        province_name: "customer_tax_province",
        tax_number: true,
        tax_number_name: "customer_tax_number",
        tax_office_name: "customer_tax_office",
    }


    var province_list = {
        "1": "ADANA",
        "2": "ADIYAMAN",
        "3": "AFYONKARAHİSAR",
        "4": "AĞRI",
        "5": "AMASYA",
        "6": "ANKARA",
        "7": "ANTALYA",
        "8": "ARTVİN",
        "9": "AYDIN",
        "10": "BALIKESİR",
        "11": "BİLECİKK",
        "12": "BİNGÖL",
        "13": "BİTLİS",
        "14": "BOLU",
        "15": "BURDUR",
        "16": "BURSA",
        "17": "ÇANAKKALE",
        "18": "ÇANKIRI",
        "19": "ÇORUM",
        "20": "DENİZLİ",
        "21": "DİYARBAKIR",
        "22": "EDİRNE",
        "23": "ELAZIĞ",
        "24": "ERZİNCAN",
        "25": "ERZURUM",
        "26": "ESKİŞEHİR",
        "27": "GAZİANTEP",
        "28": "GİRESUN",
        "29": "GÜMÜŞHANE",
        "30": "HAKKARİ",
        "31": "HATAY",
        "32": "ISPARTA",
        "33": "MERSİN",
        "34": "İSTANBUL",
        "35": "İZMİR",
        "36": "KARS",
        "37": "KASTAMONU",
        "38": "KAYSERİ",
        "39": "KIRKLARELİ",
        "40": "KIRŞEHİR",
        "41": "KOCAELİ",
        "42": "KONYA",
        "43": "KÜTAHYA",
        "44": "MALATYA",
        "45": "MANİSA",
        "46": "KAHRAMANMARAŞ",
        "47": "MARDİN",
        "48": "MUĞLA",
        "49": "MUŞ",
        "50": "NEVŞEHİR",
        "51": "NİĞDE",
        "52": "ORDU",
        "53": "RİZE",
        "54": "SAKARYA",
        "55": "SAMSUN",
        "56": "SİİRT",
        "57": "SİNOP",
        "58": "SİVAS",
        "59": "TEKİRDAĞ",
        "60": "TOKAT",
        "61": "TRABZON",
        "62": "TUNCELİ",
        "63": "ŞANLIURFA",
        "64": "UŞAK",
        "65": "VAN",
        "66": "YOZGAT",
        "67": "ZONGULDAK",
        "68": "AKSARAY",
        "69": "BAYBURT",
        "70": "KARAMAN",
        "71": "KIRIKKALE",
        "72": "BATMAN",
        "73": "ŞIRNAK",
        "74": "BARTIN",
        "75": "ARDAHAN",
        "76": "IĞDIR",
        "77": "YALOVA",
        "78": "KARABüK",
        "79": "KİLİS",
        "80": "OSMANİYE",
        "81": "DÜZCE"
    };
    var settings = $.extend({}, defaults, options);

    let content = "";
    let random_number = Math.floor((Math.random() * 10000) + 1);
    content += '<input type="hidden" name="' + set_name(settings.control_class, "secret_number", random_number) + '" value="' + random_number + '" />';


    if (settings.province) {
        let col = "", proptions = "", droptions = "", txoptions = "";
        proptions = addOption("---", "Bir il Seçiniz");
        for (let i = 0; i < Object.keys(province_list).length; i++) {
            if (typeof province_list[i] !== "undefined")
                proptions += addOption(i, province_list[i]);
        }

        let select = addSelect(proptions, set_name(settings.control_class, settings.province_name, random_number), "tax_province", random_number);
        col += addLabel("3", "Vergi Dairesi");
        col += addCol("2", select);



        if (settings.tax_number) {
            txoptions += addOption("---", "Önce İl Seçimini Yapın");
            let txselect = addSelect(txoptions, set_name(settings.control_class, settings.tax_number_name, random_number), "tax_number", random_number);

            col += addCol("2", txselect);
        }
        content += addRow(col, "margin-top-15");
    }
    const temp = tax_template(content, random_number);
    taxdraw($this, temp, settings);

};

function remove_button_event() {
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

function set_name(control_class, name, random) {
    if (typeof random !== "undefined") {
        return control_class + "@" + name + ":" + random
    } else {
        return control_class + "@" + name
    }

}
function add_title(settings, random) {
    let col = "";
    let input = addInput("text", set_name(settings.control_class, settings.title_name, random), "", "Ev adresi");
    col += addLabel("3", "Adres Başlığı");
    col += addCol("9", input);
    return addRow(col, "margin-top-15");
}



function addLabel(col = "3", text) {
    return '<label class="col-md-' + col + ' control-label">' + text + '</label>'
}
function addCol(col = "3", content) {
    return '<div class="col-md-' + col + '">' + content + '</div>'
}
function addInput(type = "text", name = "", value = "", placeholder = "") {
    return '<input class="form-control" type="' + type + '" name="' + name + '" value="' + value + '" placeholder="' + placeholder + '">'
}
function tax_template(content, id) {
    return '<div id="' + id + '" ><hr />' + content + '<hr /></div>'
}
function taxdraw($this, template, settings) {
    $this.append(template)
    taxprovinceChange(settings)
}
function taxprovinceChange(settings) {

    $('[data-type="tax_province"]').on("change", function () {

        var province = $(this), select_province_id = province.val(), selected = "", section_id = $(this).data("section_id")
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
                    let tax_option = "";
                    tax_option += addOption("---", "Bir İlçe Seçiniz");
                    for (let i = 0; i < Object.keys(data.taxplacelist).length; i++) {
                        if (typeof data.taxplacelist[i] !== "undefined")
                            if (data.taxplacelist[i].AAilceNo != 0) {
                                tax_option += addOption(data.taxplacelist[i].tax_office_id, data.districtlist[i].tax_office_name);
                                // district_option += '<option value="' + data.districtlist[i].AAilceNo + ' ' + selected + '">' + data.districtlist[i].AAilceAdi + '</option>';
                            }
                    }
                    province.parents("#" + section_id).find('[data-type="tax_number"]').html(tax_option);

                    // $('[data-select_adres="neighborhood"]').html()
                    //districtChange()
                }
            }
        });
    })
}

function myTrim(x) {
    return x.replace(/^\s+|\s+$/gm, '');
}





