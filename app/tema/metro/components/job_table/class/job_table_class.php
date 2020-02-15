<?php

/**
 * Description of class
 *
 * @author engin
 */
class job_table_class {

//put your code here
    public function __construct() {
        return true;
    }

    public function job_public($src) {
        if ($src["public"] == 1) {
            return'<span class="label label-sm label-success" data-product="public"  data-place="span" data-product_seccode= "' . $src->product_seccode . '" title="Yayından Al Durdur" > <span class="fa fa-play"></span></span>';
        } else {
            return '<span class="label label-sm label-danger" data-product="public"  data-place="span" data-product_seccode= "' . $src->product_seccode . '" title="Yayına Al"> <span class="fa fa-pause"></span></span>';
        }
    }

    public function job_number($src) {
        return $src["job_number"] == "-1" ? html::add_div([""], "Beklemede") : src["job_number"];
    }

    public function job_user($src) {
        $customer_id = $src["customer_id"];
        $ncustomer = new table_customer();
        $ncustomer->add_filter("name");
        $ncustomer->add_filter("lastname");
        $ncustomer->select();
        $ncustomer->add_condition("customer_id", $customer_id);
        $customer_data = $ncustomer->get_alldata(true);
        return ucwords_tr($customer_data->name . " " . $customer_data->lastname);
    }

    public function job_count($src) {
        return true;
    }

    public function card_total($src) {
        return true;
    }

    public function total_revenues($src) {
        return true;
    }

    public function total_payment($src) {
        return true;
    }

    public function job_time($src) {
        return true;
    }

    public function next_event($src) {
        return true;
    }

    public function actions($src) {
        $content = html::addbutton(["class" => "btn btn-xs green dropdown-toggle", "type" => "button", "data-toggle" => "dropdown", "aria-expanded" => "false"], "Eylemler" . html::addspan(["class" => "fa fa-angle-down"]));
//$li[] = ["attr" => ["class" => "fs-12 $promotion"], "html" => html::addalink(["class" => "text-black", "href" => URL . "/company/me/promotion", "role" => "tab"], "Reklamlarım")];
        $li = [];

        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "data-component_run" => "product_form",
                        "data-modal" => "#products",
                        "data-component_action" => "get_copy_product",
                        "data-component_key" => "product_id",
                        "data-component_data" => $src["product_id"],
                        "data-starter" => "form",
                    ]
                    , "Sipariş Detayları")
        ];
        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "data-component_run" => "product_form",
                        "data-modal" => "#products",
                        "data-component_action" => "get_product",
                        "data-component_key" => "product_id",
                        "data-component_data" => "{$src["product_id"]}",
                        "data-starter" => "form",
                    ]
                    , "Siparişi Tamamla")
        ];

        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "data-component_run" => "product_form",
                        "data-component_action" => "go_product",
                        "data-component_key" => "product_id",
                        "data-component_data" => $src["product_id"],
                    ]
                    , "Ürünü Git")
        ];
        if ($src["public"] == 1) {
            $li[] = [
                "html" =>
                html::addalink(
                        [
                            "data-component_run" => "product_form",
                            "data-component_action" => "pause_product",
                            "data-component_key" => "product_id",
                            "data-component_data" => $src["product_id"],
                        ]
                        , "Durdur")
            ];
        } else {
            $li[] = [
                "html" =>
                html::addalink(
                        [
                            "data-component_run" => "product_form",
                            "data-modal" => "#products",
                            "data-component_action" => "public_product",
                            "data-component_key" => "product_id",
                            "data-component_data" => $src["product_id"],
                        ]
                        , "Yayınla")
            ];
        }
        $li[] = ["attr" => ["class" => "divider"]];
        $li[] = [
            "html" =>
            html::addalink(
                    [
                        "style" => "color:#fff;font-weight:600;background: #8A2387;background: -webkit-linear-gradient(to right, #F27121, #E94057, #8A2387);background: linear-gradient(to right, #F27121, #E94057, #8A2387);",
                        "data-component_run" => "product_form",
                        "data-component_action" => "remove_product",
                        "data-component_key" => "product_id",
                        "data-component_data" => $src["product_id"],
                    ]
                    , "Siparişi Kaldır")
        ];
        $content .= html::addhtmllist(["class" => "dropdown-menu", "role" => "menu"], $li);
        $btn = html::add_div(["class" => "btn-group"], $content);
        return $btn;
    }

}
