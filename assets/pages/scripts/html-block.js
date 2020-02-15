/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$.fn.tax_seciton_block = function (options) {
    var $this = this;
    var defaults = {
        html: true,
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
    var settings = $.extend({}, defaults, options),
            random = Math.floor((Math.random() * 10000) + 1),
            html_blok;
    if (settings.html) {
        var tax_province_list = '<option value="0">Bir İl Seçiniz</option>';
        var index = 0
        var i;
        for (i = 1; i < Object.keys(province_list).length; i++) {
            tax_province_list += '<option value="' + i + '">' + province_list[i] + '</option>';
        }
        html_blok = '<div class="company_tax_section">\n\
                            <div class="row  margin-top-15">\n\
                                <input type="hidden" name="tax_random[]" value="' + random + '" />\n\
                                <label class="col-md-3 control-label">İl Seçiniz</label>\n\
                                    <div class="col-md-2">\n\
                                    <select class="form-control" data-select="tax_province" name="company_tax_province[' + random + ']">' + tax_province_list + '</select>\n\
                                    </div>\n\
                                <label class="col-md-1 control-label">Vergi Dairesi</label>\n\
                                    <div class="col-md-2">\n\
                                    <select class="form-control" data-select_adres="district" name="adres_ilce[' + random + ']"></select>\n\
                                    </div>\n\
                            </div>\n\
                            <div class="row margin-top-15">  \n\
                                <label class="col-md-3 control-label">Vergi Numarası</label>\n\
                                    <div class="col-md-7">\n\
                                     <input type="text" class="form-control" placeholder="vergi numarası" name="company_tax_number"/><span class="help-block"> Şirket Vergi Numaranız. </span>\n\
                                    </div>\n\
                                    <div class="col-sm-2">\n\
                                    <button type="none" class="btn btn-danger btn-block margin-top-25" data-company="remove_adres_section">Kaldır</button>\n\
                                    </div>\n\
                            </div>\n\
                </div>';
        $this.append(html_blok);
    }
    $('[data-select="tax_province"]').off()
    $('[data-select="tax_province"]').on("change", function () {
        var tax_province = $(this)
        var select_province_id = tax_province.val()
        var scriptURL = "/xhr/adres_block/getTaxPlace";
        toasterOption();
        $.ajax({type: "post",
            url: scriptURL,
            data: {"select_province_id": select_province_id},
            dataType: "json",
            beforeSend: function (data) {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    var taxplacelist_temp = '<option value="---">Bir İlçe Seçiniz</option>';
                    for (i = 0; i < Object.keys(data.taxplacelist).length; i++) {
                        if (data.taxplacelist[i].AAilceNo != 0) {
                            taxplacelist_temp += '<option value="' + data.taxplacelist[i].tax_office_id + '">' + data.taxplacelist[i].tax_office_name + '</option>';
                        }
                    }
                    tax_province.parents(".company_tax_section").find('[data-select="company_tax_place"]').html(taxplacelist_temp);
                    toastr["success"](data.msg)
                    $('[data-select_adres="neighborhood"]').html()

                } else {
                    toastr["danger"](data.msg)
                }
            }
        });
    })
}

$.fn.company_account_html_block = function (options) {
    var $this = this;
    var defaults = {
        html: true,
    }
    var settings = $.extend({}, defaults, options);
    var adres_count = $this.find(".adres_section").length,
            random = Math.floor((Math.random() * 10000) + 1),
            html_blok;
    if (settings.html) {
        html_blok = '<div class="account_info"><div class="row"><input type="hidden" name="account_random[]" value="' + random + '" /><label class="col-md-3 control-label">Hesap Bilgileri</label><div class="col-md-3"><input type="text" class="form-control" placeholder="Banka ismi" name="bank_name[' + random + ']"/><span class="help-block"> Banka İsmi</span></div><div class="col-md-3"><input type="text" class="form-control" placeholder="Hesap Numarası" name="account_number[' + random + ']"/><span class="help-block"> Hesap Numarası</span></div><div class="col-md-3"><button class="btn btn-danger" data-company="remove_account_info">Kaldır</button></div></div></div>';
    }
    $this.append(html_blok);
    $('[data-company="remove_account_info"]').on("click", function (e) {
        e.preventDefault();
        var $this = $(this)
        var bank_seccode = $this.data("bank_seccode");
        if (typeof bank_seccode !== "undefined") {
            var scriptURL = "/xhr/adres_block/removebankaccountblock";
            $.ajax({type: "post",
                url: scriptURL,
                data: {"bank_seccode": bank_seccode},
                dataType: "json",
                beforeSend: function (data) {
                    $("body").find(".waiting_screen").fadeIn()
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()

                    if (data.sonuc) {
                        toastr["success"](data.msg)
                        $this.parents(".account_info").fadeOut(500, function () {
                            $(this).remove()
                        })
                    } else {
                        toastr["danger"](data.msg)
                    }
                }
            });
        } else {
            $this.parents(".account_info").fadeOut(500, function () {
                $(this).remove()
            })
        }

    })



};
$.fn.adres_html_block = function (options) {
    var $this = this;
    var defaults = {
        adres_type: "customer",
        adres_seccode: null,
        costumer_seccode: null,
        adres_title: null,
        province: null,
        district: null,
        neighborhood: null,
        description: null,
        html: true,
        count: null,
        table_element: null,
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
    var province_list_temp = '<option value="0">Bir İl Seçiniz</option>';
    // alert(province_list_temp)

    var index = 0
    var i;
    var selected;
    for (i = 1; i < Object.keys(province_list).length; i++) {
        if (settings.province == i) {
            selected = "selected";
            console.log(settings.province)
        } else {
            selected = "";
        }
        province_list_temp += '<option value="' + i + '" ' + selected + '>' + province_list[i] + '</option>';
    }

    var adres_count = $this.find(".adres_section").length,
            random = Math.floor((Math.random() * 10000) + 1),
            html_blok;
    if (settings.html) {
        if (settings.adres_type == "settings") {
            html_blok = '<div class="adres_section" ><div class="row  margin-top-15"><input type="hidden" name="adres_random[]" value="' + random + '" /><label class="col-md-3 control-label">İl</label><div class="col-md-2"><select class="form-control" data-select_adres="province" name="adres_il[' + random + ']">' + province_list_temp + '</select></div><label class="col-md-1 control-label">İlce</label><div class="col-md-2"><select class="form-control" data-select_adres="district" name="adres_ilce[' + random + ']"></select></div><label class="col-md-1 control-label">Mahalle</label><div class="col-md-2">    <select class="form-control" data-select_adres="neighborhood" name="adres_mahalle[' + random + ']"></select></div></div><div class="row margin-top-15">    <label class="col-md-3 control-label">Açık Adres</label><div class="col-md-7"><textarea class="form-control" rows="1" name="adres_description[' + random + ']"  placeholder="Adresi Yazınız"></textarea></div><div class="col-sm-2"><button type="none" class="btn btn-danger btn-block" data-company="remove_adres_section">Kaldır</button></div></div></div>';
        } else if (settings.adres_type == "customer") {
            if (settings.adres_seccode !== null) {
                var adrs = 'data-adres_seccode="' + settings.adres_seccode;
            }
            var adres_title;
            if (settings.adres_title !== null) {
                adres_title = settings.adres_title
            } else {
                adres_title = "";
            }
            var costumer_seccode;
            if (settings.costumer_seccode !== null) {
                costumer_seccode = settings.costumer_seccode
            }
            var adres_description;
            if (settings.description !== null) {
                adres_description = settings.description
            } else {
                adres_description = "";
            }

            var adres_input;
            if (settings.adres_seccode !== null) {
                adres_input = '<input type="hidden" name="adres_seccode[' + random + ']"  value="' + settings.adres_seccode + '" />';
            }
            html_blok = '<div class="adres_section" ' + adrs + '" ><input type="hidden" name="adres_random[]" value="' + random + '" />' + adres_input + '<div class="row margin-top-15"><label class="col-md-3 control-label">Adres Başlık</label><div class="col-md-9"><input class="form-control" type="text" name="adres_title[' + random + ']" value="' + adres_title + '" placeholder="Ev adresi" /></div></div><div class="row  margin-top-15"><label class="col-md-3 control-label">İl</label><div class="col-md-2"><select class="form-control" data-select_adres="province" name="adres_il[' + random + ']">' + province_list_temp + '</select></div><label class="col-md-1 control-label">İlce</label><div class="col-md-2"><select class="form-control" data-select_adres="district" name="adres_ilce[' + random + ']"></select></div><label class="col-md-1 control-label">Mahalle</label><div class="col-md-2">    <select class="form-control" data-select_adres="neighborhood" name="adres_mahalle[' + random + ']"></select></div></div><div class="row margin-top-15">    <label class="col-md-3 control-label">Açık Adres</label><div class="col-md-5"><textarea class="form-control" rows="1" name="adres_description[' + random + ']" placeholder="Adresi Yazınız">' + adres_description + '</textarea></div><div class="col-sm-2"><button type="none" class="btn btn-danger btn-block margin-top-25" data-adres_seccode="' + settings.adres_seccode + '" data-company="remove_adres_section">Kaldır</button></div></div></div>';
        } else if (settings.adres_type == "search_block") {
            html_blok = '<div class="adres_section"><input type="hidden" name="adres_random[]" value="' + random + '" /><div class="row  "><div class="col-md-4"><select class="form-control" data-select_adres="province" name="adres_il[' + random + ']">' + province_list_temp + '</select></div><div class="col-md-4"><select class="form-control" data-select_adres="district" name="adres_ilce[' + random + ']"></select></div><div class="col-md-3"><select class="form-control" data-select_adres="neighborhood" name="adres_mahalle[' + random + ']"></select></div><div class="col-sm-1"><button class="btn btn-info" data-search="search_costumer_from_adres">Ara</button></div></div></div>';

        } else {
            html_blok = '<div class="adres_section"><input type="hidden" name="adres_random[]" value="' + random + '" /><div class="row margin-top-15"><label class="col-md-3 control-label">Adres Başlık</label><div class="col-md-9"><input class="form-control" type="text" name="adres_title[' + random + ']" placeholder="Ev adresi" /></div></div><div class="row  margin-top-15"><label class="col-md-3 control-label">İl</label><div class="col-md-2"><select class="form-control" data-select_adres="province" name="adres_il[' + random + ']">' + province_list_temp + '</select></div><label class="col-md-1 control-label">İlce</label><div class="col-md-2"><select class="form-control" data-select_adres="district" name="adres_ilce[' + random + ']"></select></div><label class="col-md-1 control-label">Mahalle</label><div class="col-md-2">    <select class="form-control" data-select_adres="neighborhood" name="adres_mahalle[' + random + ']"></select></div></div><div class="row margin-top-15">    <label class="col-md-3 control-label">Açık Adres</label><div class="col-md-7"><textarea class="form-control" rows="1" name="adres_description[' + random + ']" placeholder="Adresi Yazınız"></textarea></div><div class="col-sm-2"><button type="none" class="btn btn-danger btn-block margin-top-25" data-company="remove_adres_section">Kaldır</button></div></div></div>';
        }

        if (settings.district !== null) {
            var selected_district;
            var scriptURL = "/xhr/adres_block/setdistrict";
            toasterOption();
            $.ajax({type: "post",
                url: scriptURL,
                data: {"select_province_id": settings.province},
                dataType: "json",
                beforeSend: function (data) {
                    $("body").find(".waiting_screen").fadeIn()
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()
                    if (data.sonuc) {
                        var districtlist_temp = '<option value="---">Bir İlçe Seçiniz</option>';
                        for (i = 0; i < Object.keys(data.districtlist).length; i++) {
                            if (data.districtlist[i].AAilceNo != 0) {
                                if (settings.district == data.districtlist[i].AAilceNo) {
                                    selected_district = "selected";
                                } else {
                                    selected_district = "";
                                }
                                districtlist_temp += '<option value="' + data.districtlist[i].AAilceNo + '" ' + selected_district + '>' + data.districtlist[i].AAilceAdi + '</option>';
                            }
                        }
                        $this.find('[data-select_adres="district"]').html(districtlist_temp);
                        toastr["success"](data.msg)
                        districtChange()
                    } else {
                        toastr["danger"](data.msg)
                    }
                }
            });
        }

        if (settings.neighborhood !== null) {
            var selected_neighborhood;
            var scriptURL = "/xhr/adres_block/setneighborhood";
            $.ajax({type: "post",
                url: scriptURL,
                data: {"select_province_id": settings.province, "select_district_id": settings.district},
                dataType: "json",
                beforeSend: function (data) {
                    $("body").find(".waiting_screen").fadeIn()
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()
                    if (data.sonuc) {
                        var neighborhoodlist_temp = '<option value="---">Bir Semt Seçiniz Seçiniz</option>';
                        var j
                        for (i = 1; i < Object.keys(data.AASmtBckAdi).length; i++) {
                            var lastSemt = data.AASmtBckAdi[i].AASmtBckAdi
                            var _lastSemt = myTrim(lastSemt)
                            neighborhoodlist_temp += ' <optgroup label="' + myTrim(data.AASmtBckAdi[i].AASmtBckAdi) + '">';
                            for (j = 1; j < Object.keys(data.AAmhlKoyAdi).length; j++) {
                                var _AASmtBckAdi = myTrim(data.AAmhlKoyAdi[j].AASmtBckAdi);
                                if (_lastSemt === _AASmtBckAdi) {
                                    var trim_AAmhlKoyAdi = myTrim(data.AAmhlKoyAdi[j].AAmhlKoyAdi);
                                    if (trim_AAmhlKoyAdi != "") {
                                        if (settings.neighborhood == data.AAmhlKoyAdi[j].adres_id) {
                                            selected_neighborhood = "selected";
                                        } else {
                                            selected_neighborhood = ""
                                        }
                                    }
                                    neighborhoodlist_temp += '<option value="' + data.AAmhlKoyAdi[j].adres_id + '" ' + selected_neighborhood + '>' + trim_AAmhlKoyAdi + '</option>';
                                }
                            }
                            neighborhoodlist_temp += ' </optgroup>';
                        }

                        $this.find('[data-select_adres="neighborhood"]').html(neighborhoodlist_temp);
                        toastr["success"](data.msg)
                    } else {
                        toastr["danger"](data.msg)
                    }
                }
            });
        }

    }







    $this.append(html_blok);
    toasterOption();
    $('[data-select_adres="province"]').off()
    provinceChange()
    $('[data-select_adres="district"]').off()
    districtChange()
    if (settings.adres_type == "customer") {



        $('[data-company="save_adres_section"]').on("click", function (e) {
            e.preventDefault();
            $(this).parents(".adres_section").fadeOut(500, function () {
                $(this).remove()
            })
        })

    }
    if (settings.adres_type == "customer") {
        $('[data-company="remove_adres_section"]').off();
        $('[data-company="remove_adres_section"]').on("click", function (e) {
            e.preventDefault();
            var btn = $(this)
            var adres_seccode = btn.data("adres_seccode");
            if (adres_seccode !== null) {
                var scriptURL = "/xhr/sendcustomer/removecostumeradres";
                $.ajax({type: "post",
                    url: scriptURL,
                    data: {"adres_seccode": adres_seccode},
                    dataType: "json",
                    beforeSend: function (data) {
                        $("body").find(".waiting_screen").fadeIn()
                    },
                    success: function (data) {
                        $("body").find(".waiting_screen").fadeOut()

                        if (data.sonuc) {
                            toastr["success"](data.msg)
                            btn.parents(".adres_section").fadeOut(500, function () {
                                $(this).remove()
                            })
                        } else {
                            toastr["danger"](data.msg)
                        }
                    }
                });
            } else {
                $(this).parents(".adres_section").fadeOut(500, function () {
                    $(this).remove()
                })
            }

        })
    } else {
        $('[data-company="remove_adres_section"]').on("click", function (e) {
            e.preventDefault();
            var $this = $(this)
            var adres_seccode = $this.data("adres_seccode");
            if (typeof adres_seccode !== "undefined") {
                var scriptURL = "/xhr/adres_block/removeadresblock";
                $.ajax({type: "post",
                    url: scriptURL,
                    data: {"adres_seccode": adres_seccode},
                    dataType: "json",
                    beforeSend: function (data) {
                        $("body").find(".waiting_screen").fadeIn()
                    },
                    success: function (data) {
                        $("body").find(".waiting_screen").fadeOut()

                        if (data.sonuc) {
                            toastr["success"](data.msg)
                            $this.parents(".adres_section").fadeOut(500, function () {
                                $(this).remove()
                            })
                        } else {
                            toastr["danger"](data.msg)
                        }
                    }
                });
            } else {
                $(this).parents(".adres_section").fadeOut(500, function () {
                    $(this).remove()
                })
            }

        })
    }

};
function provinceChange() {
    $('[data-select_adres="province"]').on("change", function () {
        var province = $(this)
        select_province_id = province.val()
        var selected = "";
        var scriptURL = "/xhr/adres_block/setdistrict";
        toasterOption();
        $.ajax({type: "post",
            url: scriptURL,
            data: {"select_province_id": select_province_id},
            dataType: "json",
            beforeSend: function (data) {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    var districtlist_temp = '<option value="---">Bir İlçe Seçiniz</option>';
                    for (i = 0; i < Object.keys(data.districtlist).length; i++) {
                        if (data.districtlist[i].AAilceNo != 0) {
                            districtlist_temp += '<option value="' + data.districtlist[i].AAilceNo + ' ' + selected + '">' + data.districtlist[i].AAilceAdi + '</option>';
                        }
                    }
                    province.parents(".adres_section").find('[data-select_adres="district"]').html(districtlist_temp);
                    province.parents(".adres_section").find('[data-select_adres="neighborhood"]').html('<option value="---">Bir Semt Seçiniz Seçiniz</option>');
                    toastr["success"](data.msg)
                    $('[data-select_adres="neighborhood"]').html()
                    districtChange()
                } else {
                    toastr["danger"](data.msg)
                }
            }
        });
    })
}
function districtChange(select_province_id) {
    $('[data-select_adres="district"]').on("change", function () {

        var district = $(this)
        var select_district_id = district.val()

        var scriptURL = "/xhr/adres_block/setneighborhood";
        if (typeof select_province_id === "undefined") {
            select_province_id = district.parents(".adres_section").find('[data-select_adres="province"]').children("option:selected").val();
        }

        $.ajax({type: "post",
            url: scriptURL,
            data: {"select_province_id": select_province_id, "select_district_id": select_district_id},
            dataType: "json",
            beforeSend: function (data) {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    var neighborhoodlist_temp = '<option value="---">Bir Semt Seçiniz Seçiniz</option>';
                    var j
                    var i = 0;
                    for (i = 1; i < Object.keys(data.AASmtBckAdi).length; i++) {
                        var lastSemt = data.AASmtBckAdi[i].AASmtBckAdi
                        var _lastSemt = myTrim(lastSemt)
                        neighborhoodlist_temp += ' <optgroup label="' + myTrim(data.AASmtBckAdi[i].AASmtBckAdi) + '">';
                        for (j = 1; j < Object.keys(data.AAmhlKoyAdi).length; j++) {
                            var _AASmtBckAdi = myTrim(data.AAmhlKoyAdi[j].AASmtBckAdi);
                            if (_lastSemt === _AASmtBckAdi) {
                                var trim_AAmhlKoyAdi = myTrim(data.AAmhlKoyAdi[j].AAmhlKoyAdi);
                                if (trim_AAmhlKoyAdi != "")
                                    neighborhoodlist_temp += '<option value="' + data.AAmhlKoyAdi[j].adres_id + '">' + trim_AAmhlKoyAdi + '</option>';
                            }
                        }
                        neighborhoodlist_temp += ' </optgroup>';
                    }
                    console.log(neighborhoodlist_temp);
                    district.parents(".adres_section").find('[data-select_adres="neighborhood"]').html(neighborhoodlist_temp);
                    toastr["success"](data.msg)
                } else {
                    toastr["danger"](data.msg)
                }
            }
        });
    })
}
function myTrim(x) {
    return x.replace(/^\s+|\s+$/gm, '');
}
function toasterOption() {
    return  toastr.options = {
        "closeButton": true,
        "debug": true,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
}
$.fn.phone_html_block = function (options) {
    var $this = this;
    var defaults = {
        html: true,
        costumer_seccode: null,
        phone_seccode: null,
        phone_number: null,
    }
    var settings = $.extend({}, defaults, options);
    var phone_count = $this.find(".phone_section").length
    var random = Math.floor((Math.random() * 10000) + 1);
    var phone_number = "";

    if (settings.phone_number !== null) {
        phone_number = settings.phone_number
    }

    var phone_input;
    if (settings.phone_seccode !== null) {
        phone_input = '<input type="hidden" name="phone_seccode[' + random + ']"  value="' + settings.phone_seccode + '" />';
    }
    var html_blok = '<div class="row phone_section margin-top-15" data-phone_seccode="' + settings.phone_seccode + '"  >\n\
<input type="hidden" name="phone_random[]" value="' + random + '" />' + phone_input + '<label class="col-md-3 control-label">Telefon Numarası</label>\n\
<div class="col-md-6"><div class="input-group"><input type="text" class="form-control" placeholder="Telefon Numarası" value="' + phone_number + '" name="phone_number[' + random + ']"/>\n\
<div class="input-group-btn"><button type="button" class="btn btn-danger dropdown-toggle" data-phone_seccode="' + settings.phone_seccode + '" data-company="remove_phone_section" >Kaldır</button></div></div></div></div>';
    if (settings.html)
        $this.append(html_blok);

    $('[data-company="remove_phone_section"]').off()
    $('[data-company="remove_phone_section"]').on("click", function (e) {
        e.preventDefault();
        var btn = $(this)
        var phone_seccode = $(this).data("phone_seccode")
        if (phone_seccode === null) {
            $(this).parents(".phone_section").fadeOut(500, function () {
                $(this).remove()
            })
        } else {
            var scriptURL = "/xhr/sendcustomer/removecostumerphone";
            $.ajax({type: "post",
                url: scriptURL,
                data: {"phone_seccode": phone_seccode},
                dataType: "json",
                beforeSend: function (data) {
                    $("body").find(".waiting_screen").fadeIn()
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()

                    if (data.sonuc) {
                        toastr["success"](data.msg)
                        btn.parents(".phone_section").fadeOut(500, function () {
                            $(this).remove()
                        })
                    } else {
                        toastr["danger"](data.msg)
                    }
                }
            });
        }

    })
}

$.fn.credicard_html_block = function (options) {
    var $this = this;
    var month_list = {
        "1": "01",
        "2": "02",
        "3": "03",
        "4": "04",
        "5": "05",
        "6": "06",
        "7": "07",
        "8": "08",
        "9": "09",
        "10": "10",
        "11": "11",
        "12": "12",
    };
    var year_list = {
        "2019": "2019",
        "2020": "2020",
        "2021": "2021",
        "2022": "2022",
        "2023": "2023",
        "2024": "2024",
        "2025": "2025",
        "2026": "2026",
        "2027": "2027",
        "2028": "2028",
        "2029": "2029",
        "2030": "2030",
    };
    var defaults = {
        html: true,
        costumer_seccode: null,
        credicard_seccode: null,
        credicard_number: null,
        credicard_month: null,
        credicard_year: null,
    }
    var settings = $.extend({}, defaults, options);
    var month_option = '<option value="---">Ay Seçiniz</option>';
    var index = 0,
            month_selected = "",
            year_selected = "",
            index = 0
    var i;
    console.log(settings)
    for (i = 1; i < Object.keys(month_list).length + 1; i++) {
        if (settings.credicard_month !== null)
            if (settings.credicard_month == i) {
                month_selected = "selected";
            } else {
                month_selected = "";
            }
        month_option += '<option value="' + i + '" ' + month_selected + '>' + month_list[i] + '</option>';
    }

    var year_option = '<option value="---">Yıl Seçiniz</option>';
    var index = 0
    var j = 0;
    var t = 0;
    for (j = 0; j < Object.keys(year_list).length; j++) {
        t = j + 2019;
        if (settings.credicard_year !== null)
            if (settings.credicard_year == t) {
                year_selected = "selected";
            } else {
                year_selected = "";
            }
        year_option += '<option value="' + t + '" ' + year_selected + '>' + year_list[t] + '</option>';
    }

    var credicard_count = $this.find(".adres_section").length
    var random = Math.floor((Math.random() * 10000) + 1);
    var credicard_no = "";
    if (settings.credicard_number !== null) {
        credicard_no = settings.credicard_number;
    }
    var credicard_input;
    if (settings.credicard_seccode !== null) {
        credicard_input = '<input type="hidden" name="credicard_seccode[' + random + ']"  value="' + settings.credicard_seccode + '" />';
    }
    var html_blok = '<div class="row credicard_section margin-top-15"><input type="hidden" name="credicard_random[]" value="' + random + '" />' + credicard_input + '<label class="col-md-3 control-label">Kart Bilgisi</label>\n\
   <div class="col-md-2"><select class="form-control" name="credi_cart_month[' + random + ']" id="">' + month_option + '</select></div> \n\
  <div class="col-md-2"><select class="form-control" name="credi_cart_year[' + random + ']" id="">' + year_option + '</select> </div>\n\
<div class="col-md-4">\n\
<div class="input-group">\n\
<input type="text" class="form-control" placeholder="Kart Numarası" value="' + credicard_no + '" name="credicart_number[' + random + ']"/><div class="input-group-btn">\n\
<button type="button" class="btn btn-danger dropdown-toggle" data-credicard_seccode="' + settings.credicard_seccode + '" data-company="remove_credicard_section" >Kaldır</button></div></div></div></div>';
    if (settings.html) {
        $this.append(html_blok);
    }
    $('[data-company="remove_credicard_section"]').off()
    $('[data-company="remove_credicard_section"]').on("click", function (e) {
        e.preventDefault();
        var btn = $(this)
        var credicard_seccode = $(this).data("credicard_seccode")
        if (credicard_seccode === null) {
            $(this).parents(".credicard_section").fadeOut(500, function () {
                $(this).remove()
            })
        } else {
            var scriptURL = "/xhr/sendcustomer/removecostumercredicard";
            $.ajax({type: "post",
                url: scriptURL,
                data: {"credicard_seccode": credicard_seccode},
                dataType: "json",
                beforeSend: function (data) {
                    $("body").find(".waiting_screen").fadeIn()
                },
                success: function (data) {
                    $("body").find(".waiting_screen").fadeOut()

                    if (data.sonuc) {
                        toastr["success"](data.msg)
                        btn.parents(".credicard_section").fadeOut(500, function () {
                            $(this).remove()
                        })
                    } else {
                        toastr["danger"](data.msg)
                    }
                }
            });
        }


    })
}



