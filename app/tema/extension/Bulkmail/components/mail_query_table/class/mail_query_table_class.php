<?php

/**
 * Description of class
 *
 * @author engin
 */
class mail_query_table_class {

//put your code here
    public function __construct() {
        return true;
    }

    public function mail_public($src) {
        if ($src["public"] == 1) {
            return'<span class="label label-sm label-success" data-product="public"  data-place="span"   title="Yayından Al Durdur" > <span class="fa fa-play"></span></span>';
        } else {
            return '<span class="label label-sm label-danger" data-product="public"  data-place="span"   title="Yayına Al"> <span class="fa fa-pause"></span></span>';
        }
    }

    public function mail_adres($src) {
        return $src["mail"];
    }

    public function namelastname($src) {
        return $src["name"] . " " . $src["lastname"];
    }

    public function mail_subject($src) {
        return $src["mail_subject"];
    }

    public function mail_query_date($src) {

        return timeConvert($src["date"]);
    }

    public function actions($src) {

        $content = html::addbutton(["class" => "btn btn-xs green dropdown-toggle", "type" => "button", "data-toggle" => "dropdown", "aria-expanded" => "false"], "Eylemler" . html::addspan(["class" => "fa fa-angle-down"]));
//$li[] = ["attr" => ["class" => "fs-12 $promotion"], "html" => html::addalink(["class" => "text-black", "href" => URL . "/company/me/promotion", "role" => "tab"], "Reklamlarım")];
        $li = [];
        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "data-component_run" => "mail_content",
                        "data-modal" => "#mail_content_form",
                        "data-component_action" => "load",
                        "data-component_key" => "send_mail_id",
                        "data-component_data" => $src["send_mail_id"],
                        "data-starter" => "form",
                    ]
                    , "En Yukarı Taşı")
        ];
        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "data-component_run" => "mail_content",
                        "data-modal" => "#mail_content_form",
                        "data-component_action" => "load",
                        "data-component_key" => "send_mail_id",
                        "data-component_data" => $src["send_mail_id"],
                        "data-starter" => "form",
                    ]
                    , "En Aşağı Taşı")
        ];
        if ($src["public"]) {
            $li[] = [
                "html" =>
                html::addalink(
                        [
                            "data-component_run" => "mail_content",
                            "data-modal" => "#mail_content_form",
                            "data-component_action" => "load",
                            "data-component_key" => "send_mail_id",
                            "data-component_data" => $src["send_mail_id"],
                            "data-starter" => "form",
                        ]
                        , "Yayından Kaldır")
            ];
        } else {
            $li[] = [
                "html" =>
                html::addalink(
                        [
                            "data-component_run" => "mail_content",
                            "data-modal" => "#mail_content_form",
                            "data-component_action" => "load",
                            "data-component_key" => "send_mail_id",
                            "data-component_data" => $src["send_mail_id"],
                            "data-starter" => "form",
                        ]
                        , "yayına Al")
            ];
        }

        $li[] = ["attr" => ["class" => "divider"]];

        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "style" => "color:#fff;font-weight:600;background: #8A2387;background: -webkit-linear-gradient(to right, #F27121, #E94057, #8A2387);background: linear-gradient(to right, #F27121, #E94057, #8A2387);",
                        "data-component_name" => "customer_form",
                        "data-component_action" => "remove_costumer",
                        "data-component_key" => "customer_id",
                        "data-component_data" => $src["customer_id"],
                    ]
                    , "Kuyruktan Kaldır")
        ];

        $content .= html::addhtmllist(["class" => "dropdown-menu", "role" => "menu"], $li);
        $btn = html::add_div(["class" => "btn-group"], $content);


        return $btn;
    }

}
