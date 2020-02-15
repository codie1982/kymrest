<?php

/**
 * Description of class
 *
 * @author engin
 */
class customer_table_class {

//put your code here
    public function __construct() {
        return true;
    }

    public function customer_code($src) {
        return $src["customer_code"];
    }

    public function customer_name($src) {
        //dnd($src);
        $customer = $src["customer"];
        if (isset($src["customer"])) {
            switch ($customer["type"]) {
                case"personel";
                    $text = trim(ucwords_tr($src["customer_personel"][0]["name"] . " " . $src["customer_personel"][0]["lastname"]));
                    break;
                case"company";
                    if ($src["customer_company"][0]["company_type"] == "person") {
                        $text = trim(ucwords_tr($src["customer_company"][0]["customer_company_title"])) . " (Şahıs Şirketi)";
                    }

                    break;
                default :
                    $text = trim(ucwords_tr($src["customer_personel"][0]["name"] . " " . $src["customer_personel"][0]["lastname"]));
                    break;
            }
        } else {
            $text = "Kullanıcı bilgilerine erişilemiyor";
        }
        return html::add_div([], $text);
    }

    public function customer_email($src) {
        $confirm_icon = "";
        $active_mail = NODATA;
        if ($src["customer"]["type"] == "personel") {
            if (isset($src["customer_siteaccount"])) {
                $active_mail = $src["customer_siteaccount"][0]["customer_email"];
                foreach ($src["customer_mail"] as $mail) {
                    if ($mail["customer_mail"] == $active_mail) {
                        if ($mail["confirm"] == 0) {
                            $confirm_icon = '<i class="fa fa-exclamation" style="color:red"></i>';
                        }
                    }
                }
            }
        } else {
            $active_mail = $src["customer_mail"][0]["customer_mail"];
        }


        return trim($active_mail . " " . $confirm_icon);
    }

    public function customer_state($src) {
        $col = [];
        if ($src["customer"]["public"]) {
            $public_icon = '<i class="fa fa-check-circle" style="color:green" title="Kullanıcı Yayında"></i>';
        } else {
            $public_icon = '<i class="fa fa-exclamation" style="color:red" title="Kullanıcı Yayında Değil"></i>';
        }
        $col[] = ["6,6,6,6" => ["html" => $public_icon]];
        if ($src["customer"]["sales"]) {
            $sales_icon = '<i class="fa fa-check-circle" style="color:green" title="Kullanıcı Alışveriş Yapabilir"></i>';
        } else {
            $sales_icon = '<i class="fa fa-exclamation" style="color:red" title="Kullanıcı Alışveriş Yapamaz"></i>';
        }
        $col[] = ["6,6,6,6" => ["html" => $sales_icon]];
        return html::addrow($col);
    }

    public function customer_meta($src) {
        $customer = $src["customer"];
        switch ($customer["type"]) {
            case"personel":
                $adresCount = count($src["customer_adres"]);
                if ($adresCount != "0")
                    $span .= '<span class="fa fa-book" title="Kullanıcıya Ait ' . $adresCount . ' adet adres bulunmaktadır" style="cursor:pointer"></span>';
                $phoneCount = count($src["customer_phone"]);
                if ($phoneCount != "0")
                    $span .= ':&nbsp<i class="fa fa-phone-square"  title="Kullanıcıya Ait ' . $phoneCount . ' adet telefon bulunmaktadır" style="cursor:pointer"></i>';
                $credicardCount = count($src["customer_credi_card"]);
                if ($credicardCount != "0")
                    $span .= ':&nbsp<span class="fa fa-credit-card" title="Kullanıcıya Ait ' . $credicardCount . ' adet kredi kartı bilgisi bulunmaktadır" style="cursor:pointer"></span>';
                $mailCount = count($src["customer_mail"]);
                if ($mailCount != "0")
                    $span .= ':&nbsp<span class="fa fa-envelope" title="Kullanıcıya Ait ' . $mailCount . ' adet mail bilgisi bulunmaktadır" style="cursor:pointer"></span>';
                break;
            case"company":
                $adresCount = count($src["customer_adres"]);
                if ($adresCount != "0")
                    $span .= '<span class="fa fa-book" title="Kullanıcıya Ait ' . $adresCount . ' adet adres bulunmaktadır" style="cursor:pointer"></span>';
                $phoneCount = count($src["customer_phone"]);
                if ($phoneCount != "0")
                    $span .= ':&nbsp<i class="fa fa-phone-square"  title="Kullanıcıya Ait ' . $phoneCount . ' adet telefon bulunmaktadır" style="cursor:pointer"></i>';

                $mailCount = count($src["customer_mail"]);
                if ($mailCount != "0")
                    $span .= ':&nbsp<span class="fa fa-envelope" title="Kullanıcıya Ait ' . $mailCount . ' adet mail bilgisi bulunmaktadır" style="cursor:pointer"></span>';
                break;
                break;
        }

        return $span == "" ? NODATA : $span;
    }

    public function actions($src) {

        $content = html::addbutton(["class" => "btn btn-xs green dropdown-toggle", "type" => "button", "data-toggle" => "dropdown", "aria-expanded" => "false"], "Eylemler" . html::addspan(["class" => "fa fa-angle-down"]));
//$li[] = ["attr" => ["class" => "fs-12 $promotion"], "html" => html::addalink(["class" => "text-black", "href" => URL . "/company/me/promotion", "role" => "tab"], "Reklamlarım")];
        $li = [];

        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "data-component_run" => $src["customer"]["type"] == "personel" ? "customer_personel_form" : "customer_company_form",
                        "data-modal" => $src["customer"]["type"] == "personel" ? "#customers_personel" : "#customers_company",
                        "data-component_action" => "edit_costumer",
                        "data-component_key" => "customer_id",
                        "data-component_data" => $src["customer"]["customer_id"],
                        "data-starter" => "form,component_run",
                    ]
                    , "Kullanıcıyı Düzenle")
        ];



        if (!isset($src["customer_siteaccount"])) {

            if ($src["customer"]["type"] == "personel")
                $li[] = [
                    "html" =>
                    html::addalink(
                            [
                                "data-component_run" => "customer_siteaccount_form",
                                "data-modal" => "#customer_siteaccount",
                                "data-component_action" => "load",
                                "data-component_key" => "customer_id",
                                "data-component_data" => $src["customer"]["customer_id"],
                                "data-starter" => "form,component_run",
                            ]
                            , "Kullanıcı Hesabı oluştur")
                ];
        }
        $aprov_mail = false;
        if (isset($src["customer_siteaccount"])) {
            $customer_active_mail_adres = $src["customer_siteaccount"]["customer_email"];
            foreach ($src["customer_mail"] as $cm) {
                if ($cm["customer_mail"] == $customer_active_mail_adres) {
                    if ($cm["customer_mail"]["confirm"] == 0) {
                        $aprov_mail = true;
                    }
                }
            }
            if ($aprov_mail) {
                $li[] = [
                    "html" =>
                    html::addalink(
                            [
                                "data-component_run" => "customer_siteaccount_form",
                                "data-modal" => "#customer_siteaccount",
                                "data-component_action" => "load",
                                "data-component_key" => "customer_id",
                                "data-component_data" => $src["customer"]["customer_id"],
                                "data-starter" => "form,component_run",
                            ]
                            , "Kullanıcı Mail Adresini Onayla")
                ];
            }
        }
        if ($src["customer"]["type"] == "personel")
            $li[] = [
                "html" =>
                html::addalink(
                        [
                            "data-component_run" => "customer_siteaccount_form",
                            "data-modal" => "#customer_siteaccount",
                            "data-component_action" => "load",
                            "data-component_key" => "customer_id",
                            "data-component_data" => $src["customer"]["customer_id"],
                            "data-starter" => "form,component_run",
                        ]
                        , "Kullanıcı Bağlantı Zamanları")
            ];

        if (isset($src["customer_adres"])) {
            $li[] = [
                "html" =>
                html::addalink(
                        [
                            "data-component_run" => "customer_siteaccount_form",
                            "data-modal" => "#customer_siteaccount",
                            "data-component_action" => "load",
                            "data-component_key" => "customer_id",
                            "data-component_data" => $src["customer"]["customer_id"],
                            "data-starter" => "form,component_run",
                        ]
                        , "Kullanıcı Adres Bilgileri")
            ];
        }

        if (isset($src["customer_phone"])) {
            $li[] = [
                "html" =>
                html::addalink(
                        [
                            "data-component_run" => "customer_siteaccount_form",
                            "data-modal" => "#customer_siteaccount",
                            "data-component_action" => "load",
                            "data-component_key" => "customer_id",
                            "data-component_data" => $src["customer"]["customer_id"],
                            "data-starter" => "form,component_run",
                        ]
                        , "Kullanıcı Telefon Bilgileri")
            ];
        }

        if (isset($src["customer_credi_card"])) {
            $li[] = [
                "html" =>
                html::addalink(
                        [
                            "data-component_run" => "customer_siteaccount_form",
                            "data-modal" => "#customer_siteaccount",
                            "data-component_action" => "load",
                            "data-component_key" => "customer_id",
                            "data-component_data" => $src["customer"]["customer_id"],
                            "data-starter" => "form,component_run",
                        ]
                        , "Kullanıcı Kredi Kart Bilgileri")
            ];
        }

        if (isset($src["customer_mail"])) {
            $li[] = [
                "html" =>
                html::addalink(
                        [
                            "data-component_run" => "customer_siteaccount_form",
                            "data-modal" => "#customer_siteaccount",
                            "data-component_action" => "load",
                            "data-component_key" => "customer_id",
                            "data-component_data" => $src["customer"]["customer_id"],
                            "data-starter" => "form,component_run",
                        ]
                        , "Kullanıcı Mail Bilgileri")
            ];
        }
        if ($src["customer"]["type"] == "company")
            if (isset($src["customer_bank"])) {
                $li[] = [
                    "html" =>
                    html::addalink(
                            [
                                "data-component_run" => "customer_siteaccount_form",
                                "data-modal" => "#customer_siteaccount",
                                "data-component_action" => "load",
                                "data-component_key" => "customer_id",
                                "data-component_data" => $src["customer"]["customer_id"],
                                "data-starter" => "form,component_run",
                            ]
                            , "Kullanıcı Banka Bilgileri")
                ];
            }

        if ($src["customer"]["type"] == "personel")
            if (isset($src["customer_siteaccount"])) {
                $li[] = [
                    "html" =>
                    html::addalink(
                            [
                                "data-component_run" => "customer_siteaccount_form",
                                "data-modal" => "#customer_siteaccount",
                                "data-component_action" => "load",
                                "data-component_key" => "customer_id",
                                "data-component_data" => $src["customer"]["customer_id"],
                                "data-starter" => "form,component_run",
                            ]
                            , "Kullanıcı Şifre Değişikliği Oluştur")
                ];
            }


        if ($src["customer"]["public"] == 1) {
            $li[] = [
                "html" =>
                html::addalink(
                        [
                            "data-component_run" => "customer_siteaccount_form",
                            "data-modal" => "#customer_siteaccount",
                            "data-component_action" => "load",
                            "data-component_key" => "customer_id",
                            "data-component_data" => $src["customer"]["customer_id"],
                            "data-starter" => "form,component_run",
                        ]
                        , "Kullanıcı Yayından Kaldır")
            ];
        } else {
            $li[] = ["html" => html::addalink(
                        [
                            "data-component_run" => "customer_siteaccount_form",
                            "data-modal" => "#customer_siteaccount",
                            "data-component_action" => "load",
                            "data-component_key" => "customer_id",
                            "data-component_data" => $src["customer"]["customer_id"],
                            "data-starter" => "form,component_run",
                        ]
                        , "Kullanıcıyı Yayına Al")
            ];
        }
        if ($src["customer"]["type"] == "personel")
            if ($src["customer"]["public"] == 1) {
                $li[] = ["html" => html::addalink(
                            [
                                "data-component_run" => "customer_siteaccount_form",
                                "data-modal" => "#customer_siteaccount",
                                "data-component_action" => "load",
                                "data-component_key" => "customer_id",
                                "data-component_data" => $src["customer"]["customer_id"],
                                "data-starter" => "form,component_run",
                            ]
                            , "Kullanıcıyı Kısıtla")
                ];
            } else {
                $li[] = ["html" => html::addalink(
                            [
                                "data-component_run" => "customer_siteaccount_form",
                                "data-modal" => "#customer_siteaccount",
                                "data-component_action" => "load",
                                "data-component_key" => "customer_id",
                                "data-component_data" => $src["customer"]["customer_id"],
                                "data-starter" => "form,component_run",
                            ]
                            , "Kullanıcı kısıtlamasını Kaldır")
                ];
            }
        $li[] = ["attr" => ["class" => "divider"]];

        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "style" => "color:#fff;font-weight:600;background: #8A2387;background: -webkit-linear-gradient(to right, #F27121, #E94057, #8A2387);background: linear-gradient(to right, #F27121, #E94057, #8A2387);",
                        "data-component_run" => $src["customer"]["type"] == "personel" ? "customer_personel_form" : "customer_company_form",
                        "data-component_action" => "remove_costumer",
                        "data-component_key" => "customer_id",
                        "data-component_data" => $src["customer"]["customer_id"],
                    ]
                    , "Kullanıcıyı Kaldır")
        ];
        $content .= html::addhtmllist(["class" => "dropdown-menu", "role" => "menu"], $li);
        $btn = html::add_div(["class" => "btn-group"], $content);
        return $btn;
    }

}
