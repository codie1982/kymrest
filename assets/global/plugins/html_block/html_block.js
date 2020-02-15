class html_parts {
    constructor(_section_id, _options) {
        this.section_id = _section_id
        this.settings = Object.assign({}, this.defaults, _options)
    }
    addRow(content, className, formGroup) {
        if (formGroup) {
            if (typeof className !== "undefined") {

                return '<div class="form-group"><div class="row ' + className + '">' + content + '</div></div>'
            } else {
                return '<div class="form-group"><div class="row">' + content + '</div></div>'
            }
        } else {
            if (typeof className !== "undefined") {
                return '<div class="row ' + className + '">' + content + '</div>'
            } else {
                return '<div class="row">' + content + '</div>'
            }
        }


    }
    addli(liclass, content) {
        return '<li class="' + liclass + '">' + content + '</li>'
    }
    addCol(col = "3", content) {
        return '<div class="col-md-' + col + '">' + content + '</div>'
    }

    addDiv(attributes, content) {

        return '<div ' + this.setAttributes(attributes) + ' >' + content + '</div>'
    }

    parent_key() {
// return true;
    }

    primary_key(control_class, primary_id, secret_number) {
        if (secret_number == null) {
            return '<input type="hidden" name="@' + control_class + '$primary_key" value="' + primary_id + '">'
        } else {
            return '<input type="hidden" name="@' + control_class + '$primary_key:' + secret_number + '" value="' + primary_id + '">'
        }

    }

    secretNumber(control_class, secret_number) {
        return '<input type="hidden" data-secret_key="' + secret_number + '" name="@' + control_class + '$secret_number:' + secret_number + '" value="' + secret_number + '">'
    }
    addLabel(col = "3", text) {
        return '<label class="col-md-' + col + ' control-label">' + text + '</label>'
    }

    addSelect(options, name, attributes) {
        return '<select data-section_id="' + this.section_id + '" ' + this.setAttributes(attributes) + '  name="' + name + '">' + options + '</select>'
    }

    addOption(value, text, selected) {
        var select = selected == true ? "selected" : "";
        return '<option value="' + value + '"  ' + select + '>' + text.trim() + '</option>'
    }

    addOptionbyAttributes(attributes, text) {
// var select = selected == true ? "selected" : "";
//  return '<option ' + select + ' value="' + value + '">' + text + '</option>'
//        console.log(attributes);
//        console.log(text);
//        console.log(typeof text);
        let txt = text;
        if (typeof text == "string") {
            txt = txt.trim()
        }
        return '<option ' + this.setAttributes(attributes) + '  >' + txt + '</option>'
    }

    addCheckItem(attributes, name, text) {
        return `<label class="mt-checkbox">
                <input data-check="" type="checkbox" ${this.setAttributes(attributes)} name="${name}" > ${text}
                <span></span>
                </label>`
    }

    addRadioItem(attributes, name, text) {
        return `<label class="mt-radio">
                <input data-check="" type="radio" ${this.setAttributes(attributes)} name="${name}" > ${text}
                <span></span>
                </label>`
    }

    addRadioCover(inside, attributes) {
        return '<div ' + this.setAttributes(attributes) + '>' + inside + '</div>'
    }

    addCheckCover(inside, attributes) {
        return '<div ' + this.setAttributes(attributes) + '>' + inside + '</div>'
    }
    addPhoneList(col, name, attributes, selected_value) {
        let options = "";
        options = this.addOption("---", "Alan Seçiniz");
        for (let i = 0; i < this.phone_code.length; i++) {
            if (typeof this.phone_code[i] !== "undefined") {
                if (this.phone_code[i] == selected_value) {
                    options += this.addOption(this.phone_code[i], this.phone_code[i], true);
                } else {
                    options += this.addOption(this.phone_code[i], this.phone_code[i]);
                }
            }
        }
        let select = '<select  data-section_id="' + this.section_id + '" ' + this.setAttributes(attributes) + ' name="' + name + '">' + options + '</select>';
        return this.addCol(col, select);
    }

    addProvince(col, name, attributes, selected_value) {
        let options = "";
        options = this.addOption("---", "Bir il Seçiniz");
        for (let i = 0; i < Object.keys(this.province_list).length; i++) {
            if (typeof this.province_list[i] !== "undefined") {
                if (i == selected_value) {
                    options += this.addOption(i, this.province_list[i], true);
                } else {
                    options += this.addOption(i, this.province_list[i]);
                }
            }
        }
        let select = '<select data-section_id="' + this.section_id + '" ' + this.setAttributes(attributes) + ' name="' + name + '">' + options + '</select>';
        return this.addCol(col, select);
    }

    addProfession(col, name, attributes, selected_value) {
        let options = "";
        options = this.addOption("---", "Bir Meslek Seçiniz");
        for (let i = 0; i < Object.keys(this.profession_list).length; i++) {
            if (typeof this.profession_list[i] !== "undefined") {
                if (this.profession_list[i] == selected_value) {
                    options += this.addOption(this.profession_list[i], this.profession_list[i], true);
                } else {
                    options += this.addOption(this.profession_list[i], this.profession_list[i]);
                }
            }
        }
        let select = '<select  data-section_id="' + this.section_id + '" ' + this.setAttributes(attributes) + ' name="' + name + '">' + options + '</select>';
        return this.addCol(col, select);
    }

    setAttributes(attributes) {
        let attr = "";
        for (let obj in attributes) {
            if (obj == "style") {
                let style = "";
                style = 'style="';
                let style_list = attributes[obj];

                for (let sty in style_list) {
                    style += sty + ":" + style_list[sty] + ";";
                }
                style += '"';
                attr += style;
            } else {
                if (obj == "!") {
                    attr += attributes[obj];
                } else if (attributes[obj] == "!") {
                    attr += obj;
                } else {
                    attr += " " + obj + "=" + '"' + attributes[obj] + '"' + " "
                }

            }
        }
        return attr
    }

    addDistrict(col, name, attributes, selected_value, district_list) {
        let options = "";
        options = this.addOption("---", "Öncelikle Bir İl Seçiniz");
        if (district_list !== null) {
            for (let i = 0; i < district_list.length; i++) {
                if (typeof district_list[i] !== "undefined") {
                    if (district_list[i]["AAilceNo"] == selected_value) {
                        options += this.addOption(district_list[i]["AAilceNo"], district_list[i]["AAilceAdi"], true);
                    } else {
                        options += this.addOption(district_list[i]["AAilceNo"], district_list[i]["AAilceAdi"]);
                    }
                }
            }
        }
        let select = '<select data-section_id="' + this.section_id + '" ' + this.setAttributes(attributes) + ' name="' + name + '">' + options + '</select>'
        return this.addCol(col, select);
    }

    addTaxOffice(col, name, attributes, selected_value, taxoffice_list) {
        let options = "";
        options = this.addOption("---", "Öncelikle Bir İl Seçiniz");
        if (taxoffice_list !== null) {
            for (let i = 0; i < taxoffice_list.length; i++) {
                if (typeof taxoffice_list[i] !== "undefined") {
                    if (taxoffice_list[i]["tax_office_code"] == selected_value) {
                        options += this.addOption(taxoffice_list[i]["tax_office_code"], taxoffice_list[i]["tax_office_name"], true);
                    } else {
                        options += this.addOption(taxoffice_list[i]["tax_office_code"], taxoffice_list[i]["tax_office_name"]);
                    }
                }
            }
        }
        let select = '<select data-section_id="' + this.section_id + '" ' + this.setAttributes(attributes) + ' name="' + name + '">' + options + '</select>'
        return this.addCol(col, select);
    }

    addNeighborhood(col, name, attributes, selected_value, neighborhood_list, neighborhood_semtlist) {
        let options = "";
        options = this.addOption("---", "Bir Semt Seçiniz Seçiniz");
        if (neighborhood_list !== null) {
            for (let i = 1; i < neighborhood_semtlist.length; i++) {
                var lastSemt = this.myTrim(neighborhood_semtlist[i].AASmtBckAdi)
                options += ' <optgroup label="' + lastSemt + '">';
                for (let j = 1; j < neighborhood_list.length; j++) {
                    var aaSmt = this.myTrim(neighborhood_list[j].AASmtBckAdi);
                    var aaMhl = this.myTrim(neighborhood_list[j].AAmhlKoyAdi);
                    if (lastSemt == aaSmt) {
                        if (aaMhl !== "") {
                            if (selected_value == neighborhood_list[j].adres_id) {
                                options += this.addOption(neighborhood_list[j].adres_id, this.myTrim(neighborhood_list[j].AAmhlKoyAdi), true);
                            } else {
                                options += this.addOption(neighborhood_list[j].adres_id, this.myTrim(neighborhood_list[j].AAmhlKoyAdi));
                            }
                        }
                    }
                }
                options += ' </optgroup>';
            }
        }
        let select = '<select data-section_id="' + this.section_id + '" ' + this.setAttributes(attributes) + ' name="' + name + '">' + options + '</select>'
        return this.addCol(col, select);
    }
    addInput(name = "", setAttributes) {
        return '<input data-section_id="' + this.section_id + '" ' + this.setAttributes(setAttributes) + ' name="' + name + '" >'
    }
    addTextarea(name = "", text, setAttributes) {
        return '<textarea data-section_id="' + this.section_id + '" ' + this.setAttributes(setAttributes) + ' name="' + name + '" >' + text + '</textarea>'
    }

    removeButton(component_name, key) {
        if (typeof key !== "undefined") {

            return '<button style="padding-left:10px;margin-left:10px"  class="btn btn-circle red btn-outline" data-type="remove" data-component_name=' + component_name + '  data-section_id="' + this.section_id + '" data-key="' + key + '" >Kaldır</button>';
        } else {
            return '<button style="padding-left:10px;margin-left:10px"  class="btn btn-circle red btn-outline" data-type="remove" data-component_name=' + component_name + '  data-section_id="' + this.section_id + '" >Kaldır</button>';
        }

    }
    template(content, templateStyle) {
        let style = "style=";
        if (typeof templateStyle !== "undefined") {
            style += '"';
            for (let i = 0; i < templateStyle.length; i++) {
                style += templateStyle[i].parameter + ":" + templateStyle[i].value + ';';
            }
            style += '"';
        } else {
            style += '"' + 'background:#e1e1e1' + '"';
        }
        if (typeof this.settings.addlist !== "undefined") {
            if (this.settings.addlist) {
                return '<li class="' + this.settings.liclass + '" data-template  id="' + this.section_id + '" ' + style + ' >' + content + '</li>'
            } else {
                return '<div data-template  id="' + this.section_id + '" ' + style + ' >' + content + '</div>'
            }
        } else {
            return '<div data-template  id="' + this.section_id + '" ' + style + ' >' + content + '</div>'
        }


    }

    myTrim(x) {
        return x.replace(/^\s+|\s+$/gm, '');
    }
    set_name(control_class, action, secret_number, condition, condition_value) {

        let result = "";
        if (typeof condition !== "undefined") {
            result += condition + '=' + condition_value;
        }

        if (secret_number !== null) {
            result += "@" + control_class + "$" + action + ":" + secret_number
        } else {
            result += "@" + control_class + "$" + action
        }
        return result;
    }

    remove_button_event() {
        $('[data-type="remove"]').off()
        $('[data-type="remove"]').on("click", function (e) {
            e.preventDefault();
            var $this = $(this);
            var key = $(this).data("key")
            var section_id = $(this).data("section_id")
            if (typeof key !== "undefined") {
                var st = confirm("Bu İşlemi Yapmak istediğinizden Eminmisinix")
                if (st) {
                    const component_name = $(this).data("component_name")
                    const  dataoptions = {component_name: component_name, action: "remove"}
                    $.ajax({type: "post",
                        url: component_controller_url(dataoptions),
                        data: {"key": key},
                        dataType: "json",
                        beforeSend: function (data) {},
                        success: function (data) {
                            if (data.sonuc) {
                                $this.parents("#" + section_id).fadeOut(200, function () {
                                    $(this).remove()
                                })
                            }
                        }
                    });
                } else {
                    alert("Doğru Karar")
                }

            } else {
                $(this).parents("#" + section_id).fadeOut(200, function () {
                    $(this).remove()
                })
            }
        })
    }
    phone_code = new Array(
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

    province_list = {
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

    profession_list = ["Acentac\u0131", "Acente", "Acil Durum Y\u00f6netmeni", "Acil T\u0131p Teknisyeni", "Adli Bilimci", "Adli Kimyager", "Adli Tabip", "Agronomist", "Ah\u015fap Tekne Yap\u0131mc\u0131s\u0131", "Aile Hekimi", "AirBnb Ev Sahibi", "Akort\u00e7u", "Aktar", "Aktivist", "Aktris", "Akt\u00f6r", "Akt\u00fcer", "Akt\u00fcerya", "Akustik\u00e7i", "Ak\u0131\u015fkanlar Fizik\u00e7isi", "Alacak Tahsildar\u0131", "Alan Fizik\u00e7isi", "Alan Teknisyeni", "Alan Uygulamalar\u0131 Uzman\u0131", "Albay", "Ambalajc\u0131", "Ambarc\u0131", "Ambulans \u00c7al\u0131\u015fan\u0131", "Ambulans \u015fof\u00f6r\u00fc", "Amerikan Siyaset Bilimcisi", "Amiral", "Anahtarc\u0131", "Analist", "Analitik Laboratuvar Teknisyeni", "Analitik Servisler Kimyageri", "Anatomist", "Anestezi Teknikeri", "Anestezi Uzman\u0131", "Animat\u00f6r", "Anlat\u0131m Bilimci", "Antik Felsefe Uzman\u0131", "Antik Tarih Uzman\u0131", "Antika Sat\u0131c\u0131s\u0131", "Antropolog", "Apartman G\u00f6revlisi", "Apartman Y\u00f6neticisi", "Araba Sat\u0131c\u0131s\u0131", "Araba Tamircisi", "Araba Y\u0131kay\u0131c\u0131s\u0131", "Arabac\u0131", "Arabulucu", "Ara\u015ft\u0131rma Asistan\u0131", "Ara\u015ft\u0131rma Direkt\u00f6r\u00fc", "Ara\u015ft\u0131rma Ekip Lideri", "Ara\u015ft\u0131rma Kimyageri", "Ara\u015ft\u0131rma Teknisyeni", "Ara\u015ft\u0131rma ve Geli\u015ftirme (AR-GE) \u00c7al\u0131\u015fan\u0131", "Ara\u015ft\u0131rma ve Geli\u015ftirme Direkt\u00f6r\u00fc", "Ara\u015ft\u0131rma ve Geli\u015ftirme Kimyageri", "Ara\u015ft\u0131rma ve Geli\u015ftirme M\u00fcd\u00fcr\u00fc", "Ara\u015ft\u0131rma ve Geli\u015ftirme Teknisyeni", "Ara\u015ft\u0131rma ve \u0130novasyon M\u00fcd\u00fcr\u00fc", "Ara\u015ft\u0131rmac\u0131", "Ara\u015ft\u0131r\u0131c\u0131", "Arka Site Geli\u015ftiricisi", "Arkeolog", "Armat\u00f6r", "Arpist", "Artist", "Ar\u0131c\u0131", "Ar\u015fivci", "Asans\u00f6r Y\u00fckleyici", "Asans\u00f6rc\u00fc", "Asistan", "Asker", "Assay Geli\u015ftirme Uzman\u0131", "Aste\u011fmen", "Astrobiyolog", "Astrofizik\u00e7i", "Astronom", "Astronot", "Astsubay", "Astsubay Ba\u015f\u00e7avu\u015f", "Astsubay K\u0131demli Ba\u015f\u00e7avu\u015f", "Astsubay K\u0131demli \u00c7avu\u015f", "Astsubay K\u0131demli \u00dcst\u00e7avu\u015f", "Astsubay \u00c7avu\u015f", "Astsubay \u00dcst\u00e7avu\u015f", "At Besicisi", "Atlet", "Atmosfer Bilimleri Uzman\u0131", "Atomik Fizik\u00e7i", "Av Bek\u00e7isi", "Avc\u0131", "Avizeci", "Avukat", "Ayakkab\u0131 Boyac\u0131s\u0131", "Ayakkab\u0131 Tamircisi", "Ayakkab\u0131c\u0131", "Ayr\u0131cal\u0131kl\u0131 Profes\u00f6r", "Ay\u0131 Oynat\u0131c\u0131s\u0131", "A\u011f y\u00f6neticisi", "A\u015f\u00e7\u0131", "A\u015f\u00e7\u0131ba\u015f\u0131", "Bacac\u0131", "Badanac\u0131", "Baharat\u00e7\u0131", "Bah\u00e7e Bitkileri Uzman\u0131", "Bah\u00e7\u0131van", "Bakan", "Bakkal", "Bakteriyolog", "Bak\u0131c\u0131", "Bak\u0131m Asistan\u0131", "Bak\u0131rc\u0131", "Balon Pilotu", "Bal\u0131k \u00c7iftli\u011fi \u00c7al\u0131\u015fan\u0131", "Bal\u0131k\u00e7\u0131", "Bankac\u0131", "Bankac\u0131l\u0131k Uzman\u0131", "Banker", "Barmen", "Barmeyd", "Basketbolcu", "Bas\u0131n \u00c7al\u0131\u015fan\u0131", "Ba\u015f Dinleme M\u00fcd\u00fcr\u00fc (CLO)", "Ba\u015f Edit\u00f6r", "Ba\u015f Teknoloji M\u00fcd\u00fcr\u00fc (CTO)", "Ba\u015f Y\u00f6netim M\u00fcd\u00fcr\u00fc (COO)", "Ba\u015fbakan", "Ba\u015fd\u00fcmenci", "Ba\u015fhem\u015fire", "Ba\u015fkan", "Ba\u015fkomiser", "Ba\u015fpiskopos", "Ba\u015frahip", "Ba\u015f\u00e7avu\u015f", "Bebek Bak\u0131c\u0131s\u0131", "Bek\u00e7i", "Belediye Ba\u015fkan\u0131", "Belediye Meclisi \u00dcyesi", "Benzinci", "Berber", "Besi Hayvanc\u0131l\u0131\u011f\u0131 \u0130\u015f\u00e7isi", "Besicilik", "Beslenme Bilimci", "Besteci", "Bestekar", "Bilet Sat\u0131c\u0131s\u0131", "Bilet\u00e7i", "Bilgi \u0130\u015flemci", "Bilgisayar A\u011f Y\u00f6neticisi", "Bilgisayar Bilimleri Teorisyeni", "Bilgisayar M\u00fchendisi", "Bilgisayar Programc\u0131s\u0131", "Bilgisayar Tamircisi", "Bilim Ata\u015fesi", "Bilim Dan\u0131\u015fman\u0131", "Bilim Programc\u0131s\u0131", "Bilim Sanat\u00e7\u0131s\u0131", "Bilim Teknisyeni", "Bilim Yazar\u0131", "Bilim \u0130nsan\u0131", "Bilimsel Proje M\u00fcd\u00fcr\u00fc", "Bilirki\u015fi", "Bili\u015fsel (Kognitif) Psikolog", "Bili\u015fsel (Kognitif) Sinirbilimci", "Binba\u015f\u0131", "Binicilik", "Bioistatistik\u00e7i", "Birac\u0131", "Bisiklet\u00e7i", "Bisk\u00fcvici", "Bitki Genetik\u00e7isi", "Bitki Patologu", "Bitki Yeti\u015ftiricili\u011fi", "Biyoanalitik Bilimci", "Biyoenformatik Ara\u015ft\u0131rmac\u0131s\u0131", "Biyofizik\u00e7i", "Biyografi Yazar\u0131", "Biyokimyager", "Biyolog", "Biyoloji Profes\u00f6r\u00fc", "Biyolojik Antropolog", "Biyolojik Psikolog", "Biyomedikal M\u00fchendisi", "Biyomekanik\u00e7i", "Biyometeorolog", "Biyomolek\u00fcler M\u00fchendis", "Biyoteknolojist", "Biyo\u00f6l\u00e7\u00fcm Uzman\u0131", "Blogger", "Bobinajc\u0131", "Bomba \u0130mhac\u0131", "Borsa Bankeri", "Borsac\u0131", "Borucu", "Botanik\u00e7i", "Boyac\u0131", "Bozac\u0131", "Bula\u015f\u0131k\u00e7\u0131", "Buldozer Operat\u00f6r\u00fc", "Bulut (Cloud) Mimar\u0131", "Bulut Sistem (Cloud) Uzman\u0131", "B\u00f6cekbilimci (Entomolog)", "B\u00f6rek\u00e7i", "B\u00fct\u00e7e Uzman\u0131", "B\u00fcy\u00fck Veri Analisti", "B\u00fcy\u00fckel\u00e7i", "B\u00fcy\u00fcme ve Geli\u015fme Ekonomisti", "Cam Dekorasyon Uzman\u0131", "Cam Kesici", "Cam Sanat\u00e7\u0131s\u0131", "Cam \u0130\u015f\u00e7isi", "Camc\u0131", "Cebirsel Geometri Uzman\u0131", "Celep", "Cellat", "Cenaze \u0130\u015fleri \u00c7al\u0131\u015fan\u0131", "Centilmen Bilimci (Hobi Bilimcisi)", "Cerrah", "Ceza Avukat\u0131", "Cillop\u00e7u (Misket\u00e7i)", "Cost Control", "Cumhurba\u015fkan\u0131", "Dad\u0131", "Daktilograf", "Dalg\u0131\u00e7", "Dam\u0131t\u0131c\u0131", "Dans Sanat\u00e7\u0131s\u0131", "Dans\u00f6z", "Dan\u0131\u015fman", "Davran\u0131\u015f Bilimci", "Davran\u0131\u015fsal Ekonomist", "Davulcu", "Debba\u011f", "Dedektif", "Dekorat\u00f6r", "Demirci", "Demiryolu Elektrisyeni", "Demiryolu \u00c7al\u0131\u015fan\u0131", "Demiryolu \u0130\u015f\u00e7isi", "Demografik Sat\u0131c\u0131", "Dendrolog", "Denetim M\u00fcd\u00fcr\u00fc", "Denetleyici", "Denetmen", "Denet\u00e7i", "Deneysel Evrimsel Biyolog", "Deneysel Fizik\u00e7i", "Deniz M\u00fchendisi", "Denizci", "Deontolog", "Depocu", "Derici", "Derin \u00d6\u011frenme Uzman\u0131", "Dermatolog", "Desinat\u00f6r", "Devlet Memuru", "De\u011firmen \u0130\u015f\u00e7isi", "De\u011firmenci", "Dijital Pazarlama Uzman\u0131", "Dil Bilimci", "Dil Uzman\u0131", "Dilci", "Dilenci", "Diplomat", "Disk Jockey (DJ)", "Diyabet Bilimci", "Diyalekt Bilimci", "Diyetisyen", "Dizgici", "Di\u015f Cerrah\u0131", "Di\u015f Hekimi", "Di\u015f Teknisyeni", "Dok \u0130\u015f\u00e7isi", "Doktor", "Doku M\u00fchendisi", "Dokumac\u0131", "Donan\u0131m Tasar\u0131mc\u0131s\u0131", "Dondurmac\u0131", "Do\u00e7ent", "Do\u011fa Bilimci", "Do\u011fa Foto\u011fraf\u00e7\u0131s\u0131", "Do\u011fa Koruyucusu", "Do\u011fa Rehberi", "Do\u011falgazc\u0131", "Do\u011framac\u0131", "Do\u011fum Uzman\u0131", "Drone Operat\u00f6r\u00fc", "Dublajc\u0131", "Duvarc\u0131", "D\u00f6k\u00fcmc\u00fc", "D\u00f6nerci", "D\u00f6vizci", "D\u00f6\u015femeci", "D\u00fckkan \u0130\u015fleticisi", "D\u00fcmenci", "D\u00fcr\u00fcmc\u00fc", "D\u00fczenleme \u0130\u015fleri M\u00fcd\u00fcr\u00fc", "D\u00fc\u011fmeci", "D\u0131\u015f Mimar", "E-sporcu", "Ebe (Kad\u0131n Do\u011fum)", "Eczac\u0131", "Eczac\u0131 Kalfas\u0131", "Edit\u00f6r", "Ehliyet Kursu G\u00f6revlisi", "Ekolog", "Ekonometrist", "Ekonomi Teorisyeni", "Ekonomist", "El \u0130\u015f\u00e7isi", "Elektrik Ekipman\u0131 Denet\u00e7isi", "Elektrik M\u00fchendisi", "Elektrik-Elektronik M\u00fchendisi", "Elektrik\u00e7i", "Elektrisyen", "Elektrolog", "Elektronik M\u00fchendisi", "Elektronik ve Haberle\u015fme M\u00fchendisi", "Ele\u015ftirmen", "Embriyolog", "Emlak\u00e7\u0131", "Emniyet Amiri", "Emniyet Genel M\u00fcd\u00fcr\u00fc", "Endokrinolog", "End\u00fcstri M\u00fchendisi", "End\u00fcstri Sistemleri M\u00fchendisi", "End\u00fcstriyel Ekonomist", "End\u00fcstriyel Tasar\u0131mc\u0131", "Enstr\u00fcman \u0130malat\u00e7\u0131s\u0131", "Enzim Bilimci", "Epidemiyolog", "Epistemolog", "Ergonomist", "Eskici", "Estetisyen", "Etimolog", "Etnolog", "Etnom\u00fczikolog", "Etolog (Hayvan Davran\u0131\u015f\u0131 Bilimcisi)", "Ev Sahibi", "Ev han\u0131m\u0131", "Evcil Hayvan Uzman\u0131", "Evcil Hayvan Yeti\u015ftiricisi", "Evrimsel Algoritma Ara\u015ft\u0131rmac\u0131s\u0131", "Evrimsel Biyolog", "Evrimsel Ekolog", "Evrimsel Ekonomist", "Evrimsel Fizyolog", "Evrimsel Geli\u015fimsel Biyolog", "Evrimsel M\u00fchendis", "Evrimsel Robotik\u00e7i", "Evrimsel Sinirbilimci", "E\u011fitim Dan\u0131\u015fman\u0131", "E\u011fitim Metotlar\u0131 Uzman\u0131", "E\u011fitim Teknolojisti", "E\u011fitimci", "E\u011fitmen", "Fabrika \u0130\u015f\u00e7isi", "Fahi\u015fe", "Farmakolog", "Fatura Memuru", "Fenomenolog", "Fermantasyon \u0130\u015f\u00e7isi", "Fig\u00fcran", "Fikolog", "Film Yap\u0131mc\u0131s\u0131", "Film Y\u00f6netmeni", "Filogenetik\u00e7i", "Filolog", "Filozof", "Finansal Analist", "Finans\u00f6r", "Fitopatolog", "Fitososyolog", "Fiziksel Antropolog", "Fizik\u00e7i", "Fizyolog", "Fizyonomist", "Fizyopatolog", "Fizyoterapist", "Fon Toplay\u0131c\u0131", "Fon Yazar\u0131", "Fon Y\u00f6neticisi", "Fonolog", "Forklift Operat\u00f6r\u00fc", "Fotojeolog", "Foto\u011fraf\u00e7\u0131", "Freelancer", "Futbolcu", "F\u0131r\u0131nc\u0131", "F\u0131\u00e7\u0131c\u0131", "Galerici", "Gardiyan", "Garson", "Gazete Da\u011f\u0131t\u0131c\u0131s\u0131", "Gazete Sat\u0131c\u0131s\u0131", "Gazeteci", "Gazeteci Yazar", "Gelecek Bilimci (F\u00fct\u00fcrolog)", "Gelir Uzman Yard\u0131mc\u0131s\u0131", "Gelir Uzman\u0131", "Geli\u015fimsel Biyolog", "Geli\u015fimsel Psikolog", "Geli\u015ftirme Teknolojisti", "Gemici", "Gen D\u00fczenleme Y\u00f6neticisi", "Genel Yay\u0131n Y\u00f6netmeni", "Genelkurmay Ba\u015fkan\u0131", "General", "Genetik Dan\u0131\u015fman\u0131", "Genetik M\u00fchendisi", "Geneti\u011fi De\u011fi\u015ftirilmi\u015f Organizma (GDO) Uzman\u0131", "Gerontolog", "Gey\u015fa", "Gezegen Bilimci", "Gezgin", "Gezici Vaiz", "Gitarist", "Gondolcu", "Grafiker", "Gramer Uzman\u0131", "Greyder Operat\u00f6r\u00fc", "G\u00f6kbilimci", "G\u00f6relilik Fizik\u00e7isi", "G\u00f6rsel\/Ses Uzman\u0131", "G\u00f6z Doktoru", "G\u00f6zetmen", "G\u00f6zl\u00fck\u00e7\u00fc", "G\u00fcfteci", "G\u00fcmr\u00fck G\u00f6revlisi", "G\u00fcmr\u00fck Memuru", "G\u00fcmr\u00fck M\u00fc\u015favir Yard\u0131mc\u0131s\u0131", "G\u00fcmr\u00fck M\u00fc\u015faviri", "G\u00fcmr\u00fck Uzman\u0131", "G\u00fcndelik\u00e7i", "G\u00fcvenlik G\u00f6revlisi", "G\u00fcvenlik M\u00fcd\u00fcr\u00fc", "G\u00fcvenlik M\u00fchendisi", "G\u00fcvenlik Veri Analisti", "G\u00fcvenlik\u00e7i", "G\u00fczel Sanat\u00e7\u0131", "G\u00fczellik Uzman\u0131", "G\u0131da Biyoteknolojisti", "G\u0131da Kimyageri", "G\u0131da Mikrobiyologu", "G\u0131da M\u00fchendisi", "Haberci", "Haddeci", "Haham", "Hakem", "Halk Ekonomisti", "Halk Sa\u011fl\u0131\u011f\u0131 Uzman\u0131", "Halkbilimci", "Hal\u0131c\u0131", "Hamal", "Hamamc\u0131", "Hamurk\u00e2r", "Hareket Memuru", "Harita M\u00fchendisi", "Haritac\u0131", "Hastabak\u0131c\u0131", "Hastane Ara\u015ft\u0131rma Asistan\u0131", "Hastane Mali Analisti", "Hattat", "Hava Trafik Kontrol\u00f6r\u00fc", "Hava Trafik\u00e7isi", "Hava Trafi\u011fi G\u00fcvenlik Teknisyeni", "Havac\u0131", "Havac\u0131l\u0131k ve Uzay M\u00fchendisi", "Hayvan Bak\u0131c\u0131s\u0131", "Hayvan Beslenmesi Uzman\u0131", "Hayvan Teknisyeni", "Hayvan Terbiyecisi", "Hayvanat Bah\u00e7esi \u00c7al\u0131\u015fan\u0131", "Hekim Asistan\u0131", "Hematolog", "Hem\u015fire", "Herpetolog", "Hesap Denet\u00e7isi", "Hesap Uzman\u0131", "Hesaplama Bilimcisi", "Hesaplamal\u0131 Dilbilimci", "Hesaplamal\u0131 Evrimsel Biyolog", "Hesaplamal\u0131 Filogenetik\u00e7i", "Hesaplamal\u0131 Kimya Y\u00f6neticisi", "Hesaplamal\u0131 Sinirbilimci", "Heykelt\u0131ra\u015f", "Hidrobiyolog", "Hidrolik\u00e7i", "Hidrolog", "Histofizyolog", "Histopatolog", "Hizmetli", "Hizmet\u00e7i", "Hokkabaz", "Host", "Hostes", "Hukuk\u00e7u", "Hurdac\u0131", "H\u00fccre Biyologu", "H\u00fccre Hatt\u0131 Geli\u015ftirme Y\u00f6neticisi", "H\u00fccre M\u00fchendisi", "H\u0131rdavat\u00e7\u0131", "IT", "IT Destek Eleman\u0131", "Intranet Uzman\u0131", "Irgat", "Irk ve Etnisite Sosyologu", "I\u015f\u0131k\u00e7\u0131", "Jeofizik M\u00fchendisi", "Jeohidrolog", "Jeokronolog", "Jeolog", "Jeoloji M\u00fchendisi", "Jeomorfolog", "Jimnastik\u00e7i", "Jinekolog", "Jokey", "J\u00fcri", "Kabin G\u00f6revlisi", "Kabuk Soyucusu", "Kad\u0131n Berberi", "Kad\u0131n Do\u011fum Uzman\u0131", "Kad\u0131n Hastal\u0131klar\u0131 Uzman\u0131", "Kad\u0131n Terzisi", "Kahveci", "Kalayc\u0131", "Kalem M\u00fcd\u00fcr\u00fc", "Kalite Asistan\u0131", "Kalite Garanti M\u00fcd\u00fcr\u00fc", "Kalite Garanti Teknolojisti", "Kalite Kontrol Analisti", "Kalite Kontrol M\u00fcd\u00fcr\u00fc", "Kaloriferci", "Kalp ve Damar Uzman\u0131", "Kal\u0131p\u00e7\u0131", "Kamarot", "Kamera Mekani\u011fi", "Kameraman", "Kamusal Bilim \u0130nsan\u0131", "Kamyoncu", "Kaplamac\u0131", "Kaportac\u0131", "Kaptan", "Kap\u0131 Sat\u0131c\u0131s\u0131", "Kap\u0131c\u0131", "Kardinal", "Kardiyolog", "Karikat\u00fcrist", "Kariyer Diplomat\u0131", "Kariyer Y\u00f6nlendirme Dan\u0131\u015fman\u0131", "Karoserci", "Karpuzcu", "Kartograf", "Kar\u015f\u0131la\u015ft\u0131rmal\u0131 Anatomist", "Kar\u015f\u0131la\u015ft\u0131rmal\u0131 Dilbilimci", "Kar\u015f\u0131la\u015ft\u0131rmal\u0131 Politika Uzman\u0131", "Kasap", "Kasiyer", "Kat G\u00f6revlisi", "Kat\u0131 At\u0131k Teknisyeni", "Kat\u0131 Hal Fizik\u00e7isi", "Kaymakam", "Kaynak Ekonomisti", "Kaynak\u00e7\u0131", "Kay\u0131k\u00e7\u0131", "Kay\u0131t\u00e7\u0131", "Kaz\u0131c\u0131", "Kebap\u00e7\u0131", "Kemanc\u0131", "Kesimci", "Kimya M\u00fchendisi", "Kimya Teknisyeni", "Kimyager", "Kitap Ko\u00e7u", "Kitap\u00e7\u0131", "Kitlesel \u0130leti\u015fim Uzman\u0131", "Klarnet\u00e7i", "Klasik Arkeolog", "Klasik Edebiyat\u00e7\u0131", "Klimatolog (\u0130klim Bilimci)", "Klinik Ara\u015ft\u0131rma Koordinat\u00f6r\u00fc", "Klinik Ecza Asistan\u0131", "Klinik Farmakoloji Profes\u00f6r\u00fc", "Klinik Veri Ara\u015ft\u0131rmac\u0131s\u0131", "Koleksiyoncu", "Komedyen", "Komiser", "Komiser Yard\u0131mc\u0131s\u0131", "Komisyoncu", "Konserveci", "Konsolos", "Konsomatris", "Kontrol\u00f6r", "Konu\u015fma Uzman\u0131", "Konu\u015fma Yazar\u0131", "Konvey\u00f6r Operat\u00f6r\u00fc", "Kopya Edit\u00f6r\u00fc", "Kopyalay\u0131c\u0131", "Koramiral", "Koreograf", "Korgeneral", "Koro Ustas\u0131", "Korozyon Kontrol\u00f6r\u00fc", "Korsan", "Koruma G\u00f6revlisi", "Koruma Teknisyeni", "Kozmetoloji Uzman\u0131", "Kozmolog", "Krayobiyolog", "Kreatif Dan\u0131\u015fman", "Kredi Analisti", "Kriminolog", "Kriptopara Madencisi", "Kriptozoolog", "Kronobiyolog", "Kronolog", "Krupiyer", "Kuaf\u00f6r", "Kulak Burun Bo\u011fazc\u0131", "Kullan\u0131c\u0131 Deneyimi (UX) Tasar\u0131mc\u0131s\u0131", "Kumarbaz", "Kuma\u015f\u00e7\u0131", "Kumcu", "Kurban Bilimci", "Kuru Temizlemeci", "Kuruyemi\u015f\u00e7i", "Kurye", "Kuyumcu", "Ku\u015f\u00e7u", "K\u00e2hya", "K\u00e2tip", "K\u00e2\u011f\u0131t\u00e7\u0131", "K\u00f6fteci", "K\u00f6k H\u00fccre Ara\u015ft\u0131r\u0131c\u0131s\u0131", "K\u00f6ken Bilimci", "K\u00f6m\u00fcrc\u00fc", "K\u00f6pek E\u011fiticisi", "K\u00f6\u015fe Yazar\u0131", "K\u00fclt\u00fcrel Antropolog", "K\u00fcrk\u00e7\u00fc", "K\u00fctle\u00e7ekim Fizik\u00e7isi", "K\u00fct\u00fcphaneci", "K\u0131rtasiyeci", "K\u0131yaslamal\u0131 Edebiyat Uzman\u0131", "Laborant", "Laboratuar i\u015f\u00e7isi", "Laboratuvar Asistan\u0131", "Laboratuvar Okutman\u0131", "Laboratuvar Teknisyeni", "Laboratuvar Y\u00f6neticisi", "Lahmacuncu", "Lehimci", "Leksikolog", "Lepidopterolog", "Levaz\u0131mc\u0131", "Likenolog", "Limnolog", "Litograf", "Liturjiolog", "Lobici", "Lojistik Uzman\u0131", "Lokantac\u0131", "Lokman", "Lokomotif\u00e7i", "Lostrac\u0131", "Lostromo", "Lyft \u015eof\u00f6r\u00fc", "Maden Hava Kontrol Teknisyeni", "Madenci", "Makastar", "Makas\u00e7\u0131", "Maket\u00e7i", "Makina Denet\u00e7isi", "Makina M\u00fchendisi", "Makina Zabiti", "Makina \u00d6\u011frenmesi Ara\u015ft\u0131rmac\u0131s\u0131", "Makinist", "Makroekonomi Uzman\u0131", "Makyajc\u0131", "Mali Hizmetler Uzman\u0131", "Mali \u0130\u015fler M\u00fcd\u00fcr\u00fc (CFO)", "Manast\u0131r Ba\u015f Rahibesi", "Manav", "Manifaturac\u0131", "Manik\u00fcrc\u00fc", "Manken", "Mant\u0131k Bilimci", "Mant\u0131k Matematik\u00e7isi", "Marangoz", "Mare\u015fal", "Marka Tasar\u0131mc\u0131s\u0131", "Marka Uzman\u0131", "Marka Y\u00f6neticisi", "Mas\u00f6r", "Mas\u00f6z", "Matador", "Matbaac\u0131", "Matematiksel Analiz Uzman\u0131", "Matematiksel Sosyolog", "Matematik\u00e7i", "Matkap\u00e7\u0131", "Medeni Hukuk Avukat\u0131", "Mekatronik M\u00fchendisi", "Memur", "Menajer", "Mermerci", "Metal \u0130\u015fleyici", "Metal \u0130\u015f\u00e7isi", "Metalurji M\u00fchendisi", "Meteorolog", "Meteoroloji Uzman\u0131", "Metin Yazar\u0131", "Metodolog", "Metrolog", "Mevsimlik \u0130\u015f\u00e7i", "Meydanc\u0131", "Meyhaneci", "Meyve \u0130\u015f\u00e7isi", "Mezar Kaz\u0131c\u0131", "Mezarc\u0131", "Midyeci", "Mikolog", "Mikrobiyal Sistem M\u00fchendisi", "Mikrobiyolog", "Mikroekonomi Uzman\u0131", "Mikromorfolog", "Milletvekili", "Mimar", "Misyoner", "Mitolog", "Mobil Uygulama (App) Geli\u015ftiricisi", "Mobil Uygulama (App) Tasar\u0131mc\u0131s\u0131", "Mobilyac\u0131", "Moda Tasar\u0131mc\u0131s\u0131", "Modac\u0131", "Model", "Modelci", "Modelist", "Moderat\u00f6r", "Molek\u00fcler Bilimci", "Molek\u00fcler Biyolog", "Molek\u00fcler Fizik\u00e7i", "Molek\u00fcler ve H\u00fccresel Sinirbilimci", "Montajc\u0131", "Mont\u00f6r", "Morfolog", "Motor Tamircisi", "Motorcu", "Muallim", "Mucit", "Muhabbet Tellal\u0131", "Muhabir", "Muhaf\u0131z", "Muhasebeci", "Muhtar", "Multimedya Tasar\u0131mc\u0131s\u0131", "Mumyalay\u0131c\u0131", "Muzcu", "M\u00fcba\u015fir", "M\u00fcd\u00fcr", "M\u00fcd\u00fcr Yard\u0131mc\u0131s\u0131", "M\u00fcezzin", "M\u00fcfetti\u015f", "M\u00fchendis", "M\u00fchendislik Teknisyeni", "M\u00fcrebbiye", "M\u00fcste\u015far", "M\u00fcteahhit", "M\u00fctercim", "M\u00fcze Bilimci", "M\u00fcze M\u00fcd\u00fcr\u00fc", "M\u00fczik Bilimci", "M\u00fczik Direkt\u00f6r\u00fc", "M\u00fczik Enstr\u00fcman\u0131 Teknsiyeni", "M\u00fczik Y\u00f6netmeni", "M\u00fczikolog", "M\u00fczisyen", "M\u00fc\u015favir", "Nakliyeci", "Nak\u0131\u015f\u00e7\u0131", "Nalbant", "Nalbur", "Nal\u0131nc\u0131", "Nanobilimci", "Nanoteknoloji Uzman\u0131", "Nefrolog", "Nekrolog", "Nematolog", "Neonatolog", "Nicel Genetik\u00e7i", "Noter", "N\u00f6rofizyolog", "N\u00f6ropatolog", "N\u00f6ropsikolog", "N\u00f6roradyolog", "N\u00fckleer Fizik\u00e7i", "N\u00fckleer Santral \u00c7al\u0131\u015fan\u0131", "Obuac\u0131", "Ocak\u00e7\u0131", "Odac\u0131", "Oduncu", "Okul Bilim Teknisyeni", "Okul M\u00fcd\u00fcr\u00fc", "Okutman", "Ok\u00e7u", "Olas\u0131l\u0131k \u0130statistik\u00e7isi", "Onba\u015f\u0131", "Onkolog", "Onkoloji Ara\u015ft\u0131rmac\u0131s\u0131", "Onomatolog", "Ontolog", "Opera Sanat\u00e7\u0131s\u0131", "Operasyon Ara\u015ft\u0131rma Analizi Y\u00f6neticisi", "Operasyon Birim M\u00fcd\u00fcr\u00fc", "Operasyon Memuru", "Operasyonel Ara\u015ft\u0131rma M\u00fchendisi", "Operat\u00f6r", "Optalmolog", "Optik Fizik\u00e7i", "Ordinaryus Profes\u00f6r", "Organik Laboratuvar \u0130\u015f\u00e7isi", "Organizasyon Lideri", "Orgcu", "Orgeneral", "Orman M\u00fchendisi", "Orman \u0130\u015f\u00e7isi", "Ornitolog (Ku\u015f Bilimci)", "Ortopedist", "Osteolog", "Otel \u00c7al\u0131\u015fan\u0131", "Otel \u0130\u015f\u00e7isi", "Otelci", "Oto Elektrik\u00e7isi", "Oto Lastik Tamircisi", "Oto Tamircisi", "Oto Yedek Par\u00e7ac\u0131", "Otogar veya Lokanta Ayak\u00e7\u0131s\u0131", "Otolarinjolog", "Otomobil Elektrik Uzman\u0131", "Otomobil Teknisyeni", "Overlok\u00e7u", "Oymac\u0131", "Oyun Hostesi", "Oyun Yazar\u0131", "Oyuncak\u00e7\u0131", "Oyuncu", "O\u015finograf", "Paketleyici", "Paleobiyolog", "Paleoekolog", "Paleontolog", "Paleopatalog", "Paleozoolog", "Palinolog", "Palya\u00e7o", "Pandomimci", "Pansiyoncu", "Pansumanc\u0131", "Papa", "Papaz", "Paral\u0131 asker", "Paramedik", "Parazitolog", "Park bek\u00e7isi", "Past\u00f6riz\u00f6r", "Patofizyolog", "Patolog", "Pazar Ara\u015ft\u0131rmac\u0131s\u0131", "Pazarc\u0131", "Pazarlama M\u00fcd\u00fcr\u00fc", "Pazarlama Uzman\u0131", "Pediyatrist", "Pedolog", "Pencereci", "Personel M\u00fcd\u00fcr\u00fc", "Peruk\u00e7u", "Petrol Bilimci", "Petrol M\u00fchendisi", "Peynirci", "Peyzaj Mimar\u0131", "Peyzaj Teknikeri", "Pe\u00e7eteci", "Pideci", "Pilavc\u0131", "Pilot", "Piskopos", "Piyade", "Piyango Sat\u0131c\u0131s\u0131", "Piyanist", "Piyasa Dan\u0131\u015fman\u0131", "Piyasa Eri\u015fim Analisti", "Pizzac\u0131", "Plazma Fizik\u00e7isi", "Podcast \u00dcreticisi", "Polis", "Polis Memuru", "Polis \u0130mdat (155) Operat\u00f6r\u00fc", "Polis \u015eefi", "Polisajc\u0131", "Politik Modeller ve Metotlar Uzman\u0131", "Politika Bilimcisi", "Politika Teorisyeni", "Politikac\u0131", "Pompac\u0131", "Pop\u00fclasyon Genetik\u00e7isi", "Postac\u0131", "Postane M\u00fcd\u00fcr\u00fc", "Postane \u00c7al\u0131\u015fan\u0131", "Primatolog", "Profesyonel Programlar Asistan\u0131", "Profes\u00f6r", "Programlama Dilleri Uzman\u0131", "Proje Y\u00f6neticisi", "Proktolog", "Protokol G\u00f6revlisi", "Protozoolog", "Psikiyatr", "Psikobiyolog", "Psikodilbilimci", "Psikolog", "Psikolojik Dan\u0131\u015fmanl\u0131k ve Rehberlik (PDR)", "Psikopatolog", "Pteridolog", "Radyo ve Televizyon Teknisyeni", "Radyobiyolog", "Radyograf", "Radyolog", "Radyoloji Teknisyeni\/Teknikeri", "Radyoterapist", "Redakt\u00f6r", "Rehabilitasyon M\u00fchendisi", "Rehber", "Rejis\u00f6r", "Reklamc\u0131", "Rekt\u00f6r", "Rekt\u00f6r Yard\u0131mc\u0131s\u0131", "Remay\u00f6zc\u00fc", "Resepsiyon Memuru", "Resepsiyonist", "Ressam", "Retorik Ara\u015ft\u0131rmalar Uzman\u0131", "Robotik Uzman\u0131", "Robotik\u00e7i", "Romatolog", "Rot Balans\u00e7\u0131", "R\u00f6ntgenci", "R\u00f6t\u00fc\u015f Uzman\u0131", "SEO Uzman\u0131", "STEM Kariyer Dan\u0131\u015fman\u0131", "Saat Tamircisi", "Saat\u00e7i", "Safsata Uzman\u0131", "Sahil Koruma", "Saksofoncu", "Salep\u00e7i", "Sanal Asistan", "Sanat Ele\u015ftirmeni", "Sanat Restorat\u00f6r\u00fc", "Sanat Tarih\u00e7isi", "Sanat Y\u00f6netmeni", "Sanayici", "Sans\u00fcrc\u00fc", "Santral Memuru", "Sara\u00e7", "Sarraf", "Sat\u0131n Alma M\u00fcd\u00fcr\u00fc", "Sat\u0131\u015f Eleman\u0131", "Sat\u0131\u015f M\u00fcd\u00fcr\u00fc", "Sava\u015f\u00e7\u0131", "Savc\u0131", "Say\u0131 Teorisyeni", "Saz \u015eairi", "Sa\u011fl\u0131k Ara\u015ft\u0131rmalar\u0131 Asistan\u0131", "Sa\u011fl\u0131k Bilimci", "Sa\u011fl\u0131k Teknisyeni", "Sa\u011fl\u0131k Teknolojiileri Asistan\u0131", "Sedimentolog", "Sekreter", "Seksolog", "Sel\u00fcloz Operat\u00f6r\u00fc", "Semantik\u00e7i", "Semptom Bilimci", "Senarist", "Sepet\u00e7i", "Seramik Model Yap\u0131c\u0131s\u0131", "Serbest Muhasebeci Mali M\u00fc\u015favir", "Serbest Yazar", "Ses Bilimci", "Ses Efekti Teknisyeni", "Ses Sanat\u00e7\u0131s\u0131", "Ses Teknisyeni", "Seslendirme Sanat\u00e7\u0131s\u0131", "Sevk Operat\u00f6r\u00fc", "Seyis", "Siber G\u00fcvenlik Uzman\u0131", "Sicil Memuru", "Sigorta Temsilcisi", "Sigortac\u0131", "Sihirbaz", "Silah\u00e7\u0131", "Silah\u015f\u00f6r", "Silindir Operat\u00f6r\u00fc", "Simit\u00e7i", "Simyac\u0131", "Sinirbilimci (N\u00f6robiyolog)", "Sirk Sanat\u00e7\u0131s\u0131", "Sismoloji Uzman\u0131", "Sistem Analisti", "Sistem Geli\u015ftirici", "Sistem M\u00fchendisi", "Sistem Sinirbilimcisi", "Sistem Tasar\u0131mc\u0131s\u0131", "Sistem y\u00f6neticisi", "Sitolog", "Sitoteknoloji Uzman\u0131", "Sokak Sat\u0131c\u0131s\u0131", "Sokak \u00c7alg\u0131c\u0131s\u0131", "Son \u00dct\u00fcc\u00fc", "Sorgu H\u00e2kimi", "Sosyal Antropolog", "Sosyal Hizmet Uzman\u0131", "Sosyal Katman Uzman\u0131", "Sosyal Medya Dan\u0131\u015fman\u0131", "Sosyal Medya Uzman\u0131", "Sosyal Medya Y\u00f6neticisi", "Sosyal Psikolog", "Sosyobiyolog", "Sosyodilbilimci", "Sosyolog", "Sosyoloji Teorisyeni", "So\u011fuk Demirci", "Spiker", "Spor M\u00fcd\u00fcr\u00fc", "Standart M\u00fchendisi", "Stenograf", "Stilist", "Striptizci", "Su Kaynaklar\u0131 M\u00fchendisi", "Su K\u00fclt\u00fcr\u00fc Uzman\u0131", "Su Tesisat\u00e7\u0131s\u0131", "Su \u00dcr\u00fcnleri Uzman\u0131", "Subay", "Sucu", "Sufl\u00f6r", "Sulh H\u00e2kimi", "Sunucu", "Susuz Ara\u00e7 Y\u0131kama", "S\u00fcnnet\u00e7i", "S\u00fcpermarket \u00c7al\u0131\u015fan\u0131", "S\u00fcrd\u00fcr\u00fclebilirlik M\u00fchendisi", "S\u00fcrd\u00fcr\u00fclebilirlik Y\u00f6neticisi", "S\u00fcre\u00e7 M\u00fchendisi", "S\u00fcrveyan", "S\u00fcr\u00fcc\u00fcs\u00fcz Ara\u00e7 M\u00fchendisi", "S\u00fctanne", "S\u00fct\u00e7\u00fc", "S\u0131n\u0131rl\u0131 Ba\u015f Makinist", "S\u0131tma Bilimci", "Tabak\u00e7\u0131", "Tabelac\u0131", "Tahsildar", "Tah\u0131l Bilimcisi", "Tah\u0131l Uzman\u0131", "Tah\u0131l \u0130\u015fleme Operat\u00f6r\u00fc", "Taksi \u015eof\u00f6r\u00fc", "Taksici", "Taksonomist", "Tamirci", "Tarih Bilimci", "Tarihsel Dilbilimci", "Tarihsel Sosyolog", "Tarih\u00e7i", "Tar\u0131m M\u00fchendisi", "Tar\u0131m i\u015f\u00e7isi", "Tasar\u0131mc\u0131", "Tatl\u0131c\u0131", "Tavuk\u00e7u", "Tayfa", "Ta\u015flay\u0131c\u0131", "Ta\u015f\u00e7\u0131", "Ta\u015f\u0131mac\u0131l\u0131k Sistemleri M\u00fchendisi", "Tefeci", "Teknik Edit\u00f6r", "Teknik Yazar", "Tekniker", "Teknisyen", "Teknisyen Asistan\u0131", "Teknoloji Uzman\u0131", "Tekstil \u0130\u015f\u00e7isi", "Telefon operat\u00f6r\u00fc", "Telekom\u00fcnikasyon M\u00fchendisi", "Telekom\u00fcnikasyon \u00c7al\u0131\u015fan\u0131", "Telek\u0131z", "Telet\u0131p Hekimi", "Televizyon Tamircisi", "Temel Par\u00e7ac\u0131k Fizik\u00e7isi", "Temizlik\u00e7i", "Temsilci", "Teorik Biyolog", "Teorik Fizik\u00e7i", "Terapist", "Terc\u00fcman", "Terepati M\u00fcd\u00fcr\u00fc", "Terzi", "Tesisat\u00e7\u0131", "Test M\u00fchendisi", "Test Pilotu", "Tesviyeci", "Tezgahtar", "Te\u011fmen", "Te\u015frifat\u00e7\u0131", "Ticaret Hukuku Avukat\u0131", "Tiyatro Y\u00f6netmeni", "Toksikolog", "Tombalac\u0131", "Toplam Kalite M\u00fcd\u00fcr\u00fc", "Toplum Politikalar\u0131 Uzman\u0131", "Toplum Sa\u011fl\u0131\u011f\u0131 Uzman\u0131", "Toplumsal Beslenme Uzman\u0131", "Topolog", "Toprak Bilimci", "Top\u00e7u", "Tornac\u0131", "Toz Kontrol Teknisyeni", "Tramvay Operat\u00f6r\u00fc", "Tribolog", "Tuhafiyeci", "Turizm Acentesi", "Turizmci", "Tur\u015fucu", "Tuzcu", "Tu\u011fgeneral", "Tu\u011flac\u0131", "Twitch Yay\u0131nc\u0131s\u0131", "T\u00fcmamiral", "T\u00fcmgeneral", "T\u0131bbi Ara\u015ft\u0131rma Teknisyeni", "T\u0131bbi Fizik Ara\u015ft\u0131rmac\u0131s\u0131", "T\u0131bbi Hizmetler Asistan\u0131", "T\u0131bbi \u0130leti\u015fim M\u00fcd\u00fcr\u00fc", "T\u0131p Bilimci", "T\u0131p Yazar\u0131", "Uber \u015eof\u00f6r\u00fc", "Ula\u015f\u0131m Sorumlusu", "Uluslararas\u0131 Beslenme Uzman\u0131", "Uluslararas\u0131 Ekonomist", "Uluslararas\u0131 \u0130li\u015fkiler Uzman\u0131", "Ustaba\u015f\u0131", "Uydu Antenci", "Uydu Veri Analisti", "Uygulamal\u0131 Dilbilimci", "Uygulamal\u0131 Fizik\u00e7i", "Uygulamal\u0131 Matematik\u00e7i", "Uyum Teknisyeni", "Uzay Bilimcisi", "Uzay Biyologu", "Uzay Foto\u011fraf\u00e7\u0131s\u0131 (Astrofoto\u011fraf\u00e7\u0131)", "Uzay M\u00fchendisi", "Uzman Jandarma", "Uzman Onba\u015f\u0131", "Uzman \u00c7avu\u015f", "Uzun Yol Kaptan\u0131", "Uzun Yol \u015eof\u00f6r\u00fc", "U\u00e7ak Mekani\u011fi", "U\u00e7ak Pilotu", "U\u00e7u\u015f M\u00fchendisi", "U\u00e7u\u015f Teknisyeni", "U\u015fak", "Vah\u015fiya\u015fam Ara\u015ft\u0131rmac\u0131s\u0131", "Vaiz", "Vali", "Vatman", "Vergi M\u00fcfetti\u015fi", "Vergi Tahakkuk Memuru", "Vergi denetmeni", "Veri Bilimci", "Veri Haz\u0131rlama ve Kontrol \u0130\u015fletmeni", "Veri Madencisi", "Veritaban\u0131 Y\u00f6neticisi", "Vestiyerci", "Veteriner Hekim", "Veteriner Sa\u011fl\u0131k Teknikeri", "Veteriner Sa\u011fl\u0131k Teknisyeni", "Veznedar", "Video Edit\u00f6r\u00fc", "Video Jockey (VJ)", "Videograf", "Vin\u00e7 Operat\u00f6r\u00fc", "Virolog", "Vitrinci", "Viyolonselci", "Vulkanolog", "Yapay Zeka M\u00fchendisi", "Yapay Zeka Uzman\u0131", "Yap\u0131 M\u00fchendisi", "Yap\u0131sal Biyolog", "Yarbay", "Yard\u0131mc\u0131 Do\u00e7ent", "Yard\u0131mc\u0131 Hakem", "Yard\u0131mc\u0131 Hizmetli", "Yard\u0131mc\u0131 Pilot", "Yarg\u0131\u00e7", "Yat\u0131r\u0131m Uzman\u0131", "Yay\u0131n Y\u00f6netmeni", "Yay\u0131nc\u0131", "Yazar", "Yaz\u0131 \u0130\u015fleri M\u00fcd\u00fcr\u00fc", "Yaz\u0131l\u0131m Geli\u015ftirici", "Yaz\u0131l\u0131m Geli\u015ftiricisi", "Yaz\u0131l\u0131m M\u00fchendisi", "Ya\u015fam Ko\u00e7u", "Yelkenci", "Yeminli Mali M\u00fc\u015favir", "Yeminli Terc\u00fcman", "Yer G\u00f6sterici", "Yer Teknisyeni", "Yeralt\u0131 Sular\u0131 Teknisyeni", "Yer\u00f6l\u00e7meci", "Yol bek\u00e7isi", "Yol \u0130\u015faret Asistan\u0131", "Yorganc\u0131", "Yorumcu", "YouTube \u0130\u00e7erik \u00dcreticisi (YouTuber)", "Yo\u011fun Hal Fizik\u00e7isi", "Yo\u011furt\u00e7u", "Y\u00f6netici", "Y\u00f6netim Kurulu Ba\u015fkan\u0131 (CEO)", "Y\u00f6netmen", "Y\u00fczba\u015f\u0131", "Y\u00fcz\u00fcc\u00fc", "Y\u0131k\u0131c\u0131", "Zab\u0131ta", "Zoolog", "\u00c7ama\u015f\u0131rc\u0131", "\u00c7antac\u0131", "\u00c7ark\u00e7\u0131", "\u00c7at\u0131c\u0131", "\u00c7avu\u015f", "\u00c7ayc\u0131", "\u00c7evik Kuvvet", "\u00c7evirmen", "\u00c7evre Acil Durum Planlay\u0131c\u0131s\u0131", "\u00c7evre M\u00fchendisi", "\u00c7evre Projeleri Analisti", "\u00c7evre Sa\u011fl\u0131\u011f\u0131 Uzman\u0131", "\u00c7evre Uzman\u0131", "\u00c7evre Veri Analisti", "\u00c7evrebilimci", "\u00c7eyizci", "\u00c7e\u015fitlilik Dilbilimcisi", "\u00c7iftlik \u0130\u015fletici", "\u00c7ift\u00e7i", "\u00c7ikolatac\u0131", "\u00c7ilingir", "\u00c7inici", "\u00c7it\u00e7i", "\u00c7i\u00e7ek\u00e7i", "\u00c7oban", "\u00c7ocuk Doktoru", "\u00c7ocuk Hem\u015firesi", "\u00c7orap\u00e7\u0131", "\u00c7\u00f6mlek\u00e7i", "\u00c7\u00f6p i\u015f\u00e7isi", "\u00c7\u00f6p\u00e7\u00fc", "\u00c7\u0131kr\u0131k\u00e7\u0131", "\u00c7\u0131k\u0131k\u00e7\u0131", "\u00c7\u0131rak", "\u00d6n B\u00fcro Eleman\u0131", "\u00d6n Muhasebe Sorumlusu", "\u00d6n Muhasebe Yard\u0131mc\u0131 Eleman\u0131", "\u00d6n Muhasebeci", "\u00d6n Site Geli\u015ftiricisi", "\u00d6rmeci", "\u00d6zel Kalem M\u00fcd\u00fcr\u00fc", "\u00d6zel Sekt\u00f6r \u00c7al\u0131\u015fan\u0131", "\u00d6zel \u015eof\u00f6r", "\u00d6\u011frenci", "\u00d6\u011fretim Eleman\u0131", "\u00d6\u011fretim G\u00f6revlisi", "\u00d6\u011fretim \u00dcyesi", "\u00d6\u011fretmen", "\u00dcretici", "\u00dcrolog", "\u00dcr\u00fcn Deneticisi", "\u00dcr\u00fcn M\u00fchendisi", "\u00dcr\u00fcn Test M\u00fcd\u00fcr\u00fc", "\u00dcr\u00fcn Test Uzman\u0131", "\u00dcst D\u00fczey Y\u00f6netici", "\u00dcste\u011fmen", "\u00dct\u00fcc\u00fc", "\u00dcz\u00fcmc\u00fc", "\u0130cra Avukat\u0131", "\u0130cra Memuru", "\u0130deolog", "\u0130hracat\u00e7\u0131", "\u0130htiyolog (Bal\u0131k Bilimci)", "\u0130klim Veri Analisti", "\u0130ktisat\u00e7\u0131", "\u0130lahiyat\u00e7\u0131", "\u0130la\u00e7 Denetim \u0130\u015fleri Y\u00f6neticisi", "\u0130la\u00e7 Denetmeni", "\u0130la\u00e7 Kimyageri", "\u0130leti\u015fim Ara\u015ft\u0131rmac\u0131s\u0131", "\u0130leti\u015fim M\u00fchendisi", "\u0130ll\u00fczyonist", "\u0130mam", "\u0130mm\u00fcnolog", "\u0130mm\u00fcnopatolog", "\u0130nsan Fakt\u00f6rleri M\u00fchendisi", "\u0130nsan Kaynaklar\u0131 Uzman\u0131", "\u0130n\u015faat M\u00fchendisi", "\u0130n\u015faat\u00e7\u0131", "\u0130plik\u00e7i", "\u0130p\u00e7i", "\u0130statistik Teorisyeni", "\u0130statistik\u00e7i", "\u0130stihk\u00e2mc\u0131", "\u0130tfaiye", "\u0130tfaiyeci", "\u0130thalat\u00e7\u0131", "\u0130\u00e7 Mimar", "\u0130\u00e7erik Moderat\u00f6r\u00fc", "\u0130\u00e7erik Pazarlay\u0131c\u0131", "\u0130\u00e7erik \u00dcreticisi", "\u0130\u011fneci", "\u0130\u015f Analisti", "\u0130\u015f Ekonomisti", "\u0130\u015f Sistem Analisti", "\u0130\u015f ve U\u011fra\u015f\u0131 Terapisti", "\u0130\u015faret\u00e7i", "\u0130\u015flem Dan\u0131\u015fman\u0131", "\u0130\u015fletme M\u00fchendisi", "\u0130\u015fletmeci", "\u0130\u015fportac\u0131", "\u0130\u015f\u00e7i", "\u015eahinci", "\u015eair", "\u015eapel Papaz\u0131", "\u015eapkac\u0131", "\u015earap \u00dcreticisi", "\u015earap\u00e7\u0131", "\u015eark\u00fcter", "\u015eark\u00fcteri, G\u0131da Pazarlar\u0131 ve Bakkal Sat\u0131\u015f Eleman\u0131", "\u015eark\u0131 S\u00f6z\u00fc Yazar\u0131", "\u015eark\u0131c\u0131", "\u015earlatan", "\u015eehir Planc\u0131s\u0131", "\u015eehir ve B\u00f6lge Planlama", "\u015eekerci", "\u015eemsiyeci", "\u015eifre \u00c7\u00f6z\u00fcc\u00fc", "\u015eifre \u00c7\u00f6z\u00fcmleyici", "\u015eim\u015firci", "\u015eirket Avukat\u0131", "\u015eof\u00f6r", "Ba\u015fka Bir Meslek\u0131"];
    country_list = [{"name": "Afghanistan", "code": "AF"}, {"name": "Åland Islands", "code": "AX"}, {"name": "Albania", "code": "AL"}, {"name": "Algeria", "code": "DZ"}, {"name": "American Samoa", "code": "AS"}, {"name": "AndorrA", "code": "AD"}, {"name": "Angola", "code": "AO"}, {"name": "Anguilla", "code": "AI"}, {"name": "Antarctica", "code": "AQ"}, {"name": "Antigua and Barbuda", "code": "AG"}, {"name": "Argentina", "code": "AR"}, {"name": "Armenia", "code": "AM"}, {"name": "Aruba", "code": "AW"}, {"name": "Australia", "code": "AU"}, {"name": "Austria", "code": "AT"}, {"name": "Azerbaijan", "code": "AZ"}, {"name": "Bahamas", "code": "BS"}, {"name": "Bahrain", "code": "BH"}, {"name": "Bangladesh", "code": "BD"}, {"name": "Barbados", "code": "BB"}, {"name": "Belarus", "code": "BY"}, {"name": "Belgium", "code": "BE"}, {"name": "Belize", "code": "BZ"}, {"name": "Benin", "code": "BJ"}, {"name": "Bermuda", "code": "BM"}, {"name": "Bhutan", "code": "BT"}, {"name": "Bolivia", "code": "BO"}, {"name": "Bosnia and Herzegovina", "code": "BA"}, {"name": "Botswana", "code": "BW"}, {"name": "Bouvet Island", "code": "BV"}, {"name": "Brazil", "code": "BR"}, {"name": "British Indian Ocean Territory", "code": "IO"}, {"name": "Brunei Darussalam", "code": "BN"}, {"name": "Bulgaria", "code": "BG"}, {"name": "Burkina Faso", "code": "BF"}, {"name": "Burundi", "code": "BI"}, {"name": "Cambodia", "code": "KH"}, {"name": "Cameroon", "code": "CM"}, {"name": "Canada", "code": "CA"}, {"name": "Cape Verde", "code": "CV"}, {"name": "Cayman Islands", "code": "KY"}, {"name": "Central African Republic", "code": "CF"}, {"name": "Chad", "code": "TD"}, {"name": "Chile", "code": "CL"}, {"name": "China", "code": "CN"}, {"name": "Christmas Island", "code": "CX"}, {"name": "Cocos (Keeling) Islands", "code": "CC"}, {"name": "Colombia", "code": "CO"}, {"name": "Comoros", "code": "KM"}, {"name": "Congo", "code": "CG"}, {"name": "Congo, The Democratic Republic of the", "code": "CD"}, {"name": "Cook Islands", "code": "CK"}, {"name": "Costa Rica", "code": "CR"}, {"name": "Cote D'Ivoire", "code": "CI"}, {"name": "Croatia", "code": "HR"}, {"name": "Cuba", "code": "CU"}, {"name": "Cyprus", "code": "CY"}, {"name": "CzechRepublic", "code": "CZ"}, {"name": "Denmark", "code": "DK"}, {"name": "Djibouti", "code": "DJ"}, {"name": "Dominica", "code": "DM"}, {"name": "DominicanRepublic", "code": "DO"}, {"name": "Ecuador", "code": "EC"}, {"name": "Egypt", "code": "EG"}, {"name": "ElSalvador", "code": "SV"}, {"name": "EquatorialGuinea", "code": "GQ"}, {"name": "Eritrea", "code": "ER"}, {"name": "Estonia", "code": "EE"}, {"name": "Ethiopia", "code": "ET"}, {"name": "FalklandIslands(Malvinas)", "code": "FK"}, {"name": "FaroeIslands", "code": "FO"}, {"name": "Fiji", "code": "FJ"}, {"name": "Finland", "code": "FI"}, {"name": "France", "code": "FR"}, {"name": "FrenchGuiana", "code": "GF"}, {"name": "FrenchPolynesia", "code": "PF"}, {"name": "FrenchSouthernTerritories", "code": "TF"}, {"name": "Gabon", "code": "GA"}, {"name": "Gambia", "code": "GM"}, {"name": "Georgia", "code": "GE"}, {"name": "Germany", "code": "DE"}, {"name": "Ghana", "code": "GH"}, {"name": "Gibraltar", "code": "GI"}, {"name": "Greece", "code": "GR"}, {"name": "Greenland", "code": "GL"}, {"name": "Grenada", "code": "GD"}, {"name": "Guadeloupe", "code": "GP"}, {"name": "Guam", "code": "GU"}, {"name": "Guatemala", "code": "GT"}, {"name": "Guernsey", "code": "GG"}, {"name": "Guinea", "code": "GN"}, {"name": "Guinea-Bissau", "code": "GW"}, {"name": "Guyana", "code": "GY"}, {"name": "Haiti", "code": "HT"}, {"name": "HeardIslandandMcdonaldIslands", "code": "HM"}, {"name": "HolySee(VaticanCityState)", "code": "VA"}, {"name": "Honduras", "code": "HN"}, {"name": "HongKong", "code": "HK"}, {"name": "Hungary", "code": "HU"}, {"name": "Iceland", "code": "IS"}, {"name": "India", "code": "IN"}, {"name": "Indonesia", "code": "ID"}, {"name": "Iran/,IslamicRepublicOf", "code": "IR"}, {"name": "Iraq", "code": "IQ"}, {"name": "Ireland", "code": "IE"}, {"name": "IsleofMan", "code": "IM"}, {"name": "Israel", "code": "IL"}, {"name": "Italy", "code": "IT"}, {"name": "Jamaica", "code": "JM"}, {"name": "Japan", "code": "JP"}, {"name": "Jersey", "code": "JE"}, {"name": "Jordan", "code": "JO"}, {"name": "Kazakhstan", "code": "KZ"}, {"name": "Kenya", "code": "KE"}, {"name": "Kiribati", "code": "KI"}, {"name": "Korea,DemocraticPeople'SRepublicof", "code": "KP"}, {"name": "Korea,Republicof", "code": "KR"}, {"name": "Kuwait", "code": "KW"}, {"name": "Kyrgyzstan", "code": "KG"}, {"name": "LaoPeople'SDemocraticRepublic", "code": "LA"}, {"name": "Latvia", "code": "LV"}, {"name": "Lebanon", "code": "LB"}, {"name": "Lesotho", "code": "LS"}, {"name": "Liberia", "code": "LR"}, {"name": "LibyanArabJamahiriya", "code": "LY"}, {"name": "Liechtenstein", "code": "LI"}, {"name": "Lithuania", "code": "LT"}, {"name": "Luxembourg", "code": "LU"}, {"name": "Macao", "code": "MO"}, {"name": "Macedonia,TheFormerYugoslavRepublicof", "code": "MK"}, {"name": "Madagascar", "code": "MG"}, {"name": "Malawi", "code": "MW"}, {"name": "Malaysia", "code": "MY"}, {"name": "Maldives", "code": "MV"}, {"name": "Mali", "code": "ML"}, {"name": "Malta", "code": "MT"}, {"name": "MarshallIslands", "code": "MH"}, {"name": "Martinique", "code": "MQ"}, {"name": "Mauritania", "code": "MR"}, {"name": "Mauritius", "code": "MU"}, {"name": "Mayotte", "code": "YT"}, {"name": "Mexico", "code": "MX"}, {"name": "Micronesia,FederatedStatesof", "code": "FM"}, {"name": "Moldova,Republicof", "code": "MD"}, {"name": "Monaco", "code": "MC"}, {"name": "Mongolia", "code": "MN"}, {"name": "Montserrat", "code": "MS"}, {"name": "Morocco", "code": "MA"}, {"name": "Mozambique", "code": "MZ"}, {"name": "Myanmar", "code": "MM"}, {"name": "Namibia", "code": "NA"}, {"name": "Nauru", "code": "NR"}, {"name": "Nepal", "code": "NP"}, {"name": "Netherlands", "code": "NL"}, {"name": "NetherlandsAntilles", "code": "AN"}, {"name": "NewCaledonia", "code": "NC"}, {"name": "NewZealand", "code": "NZ"}, {"name": "Nicaragua", "code": "NI"}, {"name": "Niger", "code": "NE"}, {"name": "Nigeria", "code": "NG"}, {"name": "Niue", "code": "NU"}, {"name": "NorfolkIsland", "code": "NF"}, {"name": "NorthernMarianaIslands", "code": "MP"}, {"name": "Norway", "code": "NO"}, {"name": "Oman", "code": "OM"}, {"name": "Pakistan", "code": "PK"}, {"name": "Palau", "code": "PW"}, {"name": "PalestinianTerritory,Occupied", "code": "PS"}, {"name": "Panama", "code": "PA"}, {"name": "PapuaNewGuinea", "code": "PG"}, {"name": "Paraguay", "code": "PY"}, {"name": "Peru", "code": "PE"}, {"name": "Philippines", "code": "PH"}, {"name": "Pitcairn", "code": "PN"}, {"name": "Poland", "code": "PL"}, {"name": "Portugal", "code": "PT"}, {"name": "PuertoRico", "code": "PR"}, {"name": "Qatar", "code": "QA"}, {"name": "Reunion", "code": "RE"}, {"name": "Romania", "code": "RO"}, {"name": "RussianFederation", "code": "RU"}, {"name": "RWANDA", "code": "RW"}, {"name": "SaintHelena", "code": "SH"}, {"name": "SaintKittsandNevis", "code": "KN"}, {"name": "SaintLucia", "code": "LC"}, {"name": "SaintPierreandMiquelon", "code": "PM"}, {"name": "SaintVincentandtheGrenadines", "code": "VC"}, {"name": "Samoa", "code": "WS"}, {"name": "SanMarino", "code": "SM"}, {"name": "SaoTomeandPrincipe", "code": "ST"}, {"name": "SaudiArabia", "code": "SA"}, {"name": "Senegal", "code": "SN"}, {"name": "SerbiaandMontenegro", "code": "CS"}, {"name": "Seychelles", "code": "SC"}, {"name": "SierraLeone", "code": "SL"}, {"name": "Singapore", "code": "SG"}, {"name": "Slovakia", "code": "SK"}, {"name": "Slovenia", "code": "SI"}, {"name": "SolomonIslands", "code": "SB"}, {"name": "Somalia", "code": "SO"}, {"name": "SouthAfrica", "code": "ZA"}, {"name": "SouthGeorgiaandtheSouthSandwichIslands", "code": "GS"}, {"name": "Spain", "code": "ES"}, {"name": "SriLanka", "code": "LK"}, {"name": "Sudan", "code": "SD"}, {"name": "Suriname", "code": "SR"}, {"name": "SvalbardandJanMayen", "code": "SJ"}, {"name": "Swaziland", "code": "SZ"}, {"name": "Sweden", "code": "SE"}, {"name": "Switzerland", "code": "CH"}, {"name": "SyrianArabRepublic", "code": "SY"}, {"name": "Taiwan,ProvinceofChina", "code": "TW"}, {"name": "Tajikistan", "code": "TJ"}, {"name": "Tanzania,UnitedRepublicof", "code": "TZ"}, {"name": "Thailand", "code": "TH"}, {"name": "Timor-Leste", "code": "TL"}, {"name": "Togo", "code": "TG"}, {"name": "Tokelau", "code": "TK"}, {"name": "Tonga", "code": "TO"}, {"name": "TrinidadandTobago", "code": "TT"}, {"name": "Tunisia", "code": "TN"}, {"name": "Turkey", "code": "TR"}, {"name": "Turkmenistan", "code": "TM"}, {"name": "TurksandCaicosIslands", "code": "TC"}, {"name": "Tuvalu", "code": "TV"}, {"name": "Uganda", "code": "UG"}, {"name": "Ukraine", "code": "UA"}, {"name": "UnitedArabEmirates", "code": "AE"}, {"name": "UnitedKingdom", "code": "GB"}, {"name": "UnitedStates", "code": "US"}, {"name": "UnitedStatesMinorOutlyingIslands", "code": "UM"}, {"name": "Uruguay", "code": "UY"}, {"name": "Uzbekistan", "code": "UZ"}, {"name": "Vanuatu", "code": "VU"}, {"name": "Venezuela", "code": "VE"}, {"name": "VietNam", "code": "VN"}, {"name": "VirginIslands,British", "code": "VG"}, {"name": "VirginIslands,U.S.", "code": "VI"}, {"name": "WallisandFutuna", "code": "WF"}, {"name": "WesternSahara", "code": "EH"}, {"name": "Yemen", "code": "YE"}, {"name": "Zambia", "code": "ZM"}, {"name": "Zimbabwe", "code": "ZW"}];

}

