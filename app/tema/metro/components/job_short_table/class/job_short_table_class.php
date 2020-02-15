<?php

/**
 * Description of class
 *
 * @author engin
 */
class job_short_table_class {

//put your code here
    public function __construct() {
        return true;
    }

    public function style($src, $random) {
        if ($src["job"]["confirm"] == 0) {
            return "background-color: #ffe2e0";
        } else {
            if ($src["job"]["prepare"] == 0) {
                return "background-color: #e2ff9b";
            } else {
                if ($src["job"]["delivery"] == 0) {
                    return "background-color: #d0ff5c";
                } else {
                    if ($src["job"]["delivery_complete"] == 0) {
                        return "background-color: #5cff9d";
                    } else {
                        if ($src["job"]["complete"] == 0) {
                            return "background-color: #5cf0ff";
                        }
                    }
                }
            }
        }
//        if ($src["job"]["confirm"] == 0) {
//            return "background-color: #ffe2e0";
//        } else {
//            return "background-color:#ffffff"; //["background-color" => "#ffffff"];
//        }
    }

    public function job_public($src) {

        if ($src["job"]["job_number"] != "-1") {
            if ($src["job"]["admin_view"] == 0) {
                return'<span class="label label-sm label-warning text eye"  title="Sipariş Görüntülenmemiş" style="font-weight:900;" > <span class="fa fa-exclamation"></span></span>';
            } else {
                return'<span class="label label-sm label-success text eye"  title="Sipariş Görüntülenmiş" > <span class="fa fa-eye"></span></span>';
            }
        } else {
            if ($src["job"]["public"] == 1) {
                return'<span class="label label-sm label-success" title="Yayından Al Durdur" > <span class="fa fa-play"></span></span>';
            } else {
                return '<span class="label label-sm label-danger" title="Yayına Al"> <span class="fa fa-pause"></span></span>';
            }
        }
    }

    public function job_payment_method($src) {
        if ($src["job"]["admin_view"] == 0) {
            return $src["job"]["job_number"] == "-1" ? html::add_div([], "Sepette") : html::add_div(["class" => "text", "style" => "font-weight:900;color:#777777"], $src["job"]["job_number"]);
        } else {
            return $src["job"]["job_number"] == "-1" ? html::add_div([], "Sepette") : html::add_div([], $src["job"]["job_number"]);
        }
    }

    public function job_status($src) {
        if ($src["job"]["admin_view"] == 0) {
            return $src["job"]["job_number"] == "-1" ? html::add_div([], "Sepette") : html::add_div(["class" => "text", "style" => "font-weight:900;color:#777777"], $src["job"]["job_number"]);
        } else {
            return $src["job"]["job_number"] == "-1" ? html::add_div([], "Sepette") : html::add_div([], $src["job"]["job_number"]);
        }
    }

    public function job_customer($src) {
        $customer_id = $src["job"]["customer_id"];
        $ncustomer = new table_customer_personel();
        $ncustomer->add_filter("name");
        $ncustomer->add_filter("lastname");
        $ncustomer->select();
        $ncustomer->add_condition("customer_id", $customer_id);
        $ncustomer->add_join("customer", "customer_id");
        if ($customer_data = $ncustomer->get_alldata(true)) {
            if ($src["job"]["admin_view"] == 0) {
                return html::add_div(["class" => "text", "style" => "font-weight:900;color:#777777"], ucwords_tr($customer_data->name . " " . $customer_data->lastname));
            } else {
                return html::add_div([], ucwords_tr($customer_data->name . " " . $customer_data->lastname));
            }
        } else {
            if ($src["job"]["admin_view"] == 0) {
                return html::add_div(["class" => "text", "style" => "font-weight:900;color:#777777"], "Kullanıcı Sistemden Kaldırılmış");
            } else {
                return html::add_div([], "Kullanıcı Sistemden Kaldırılmış");
            }
        }
    }

    public function job_product_count($src) {
        if ($src["job"]["admin_view"] == 0) {
            return html::add_div(["class" => "text", "style" => "font-weight:900;color:#777777"], count($src["job_products"]));
        } else {
            return html::add_div([], count($src["job_products"]));
        }
    }

    public function job_deliverytime($src) {
        $delivery_text = NODATA;
        if ($src["job"]["job_delivery_time"] != NOTIME) {
            $delivery_text = timeConvert($src["job"]["job_delivery_time"]);
        }
        return html::add_div([], $delivery_text);
    }

    public function card_total($src) {
        $jobModule = new job_module();
        if ($src["job"]["admin_view"] == 0) {
            return html::add_div(["class" => "text", "style" => "font-weight:900;color:#777777"], number_format($src["job"]["job_total_price"], 2) . " " . (strtoupper($job_price_info["product_currency"])));
        } else {
            return html::add_div([], number_format($src["job"]["job_total_price"], 2) . " " . (strtoupper($job_price_info["product_currency"])));
        }
    }

    public function product_show_detail($src) {
        return html::addbutton(["class" => "btn btn-xs btn-block green", "data-show" => "job_product_detail", "data-key" => $src["job"]["job_id"]], "Göster");
    }

    public function job_product_state($src) {
        if ($src["job"]["confirm"] == 0) {
            return html::addbutton(["class" => "btn btn-xs btn-block green", "data-show" => "job_confirm", "data-key" => $src["job"]["job_id"]], "Onayla");
        } else {
            if ($src["job"]["prepare"] == 0) {
                return html::addbutton(["class" => "btn btn-xs btn-block green", "data-show" => "job_prepare", "data-key" => $src["job"]["job_id"]], "Hazırlandı");
            } else {
                if ($src["job"]["delivery"] == 0) {
                    return html::addbutton(["class" => "btn btn-xs btn-block green", "data-show" => "job_delivery", "data-key" => $src["job"]["job_id"]], "Yolda");
                } else {
                    if ($src["job"]["delivery_complete"] == 0) {
                        return html::addbutton(["class" => "btn btn-xs btn-block green", "data-show" => "job_delivery_complete", "data-key" => $src["job"]["job_id"]], "Teslim Edildi");
                    } else {
                        if ($src["job"]["complete"] == 0) {
                            return html::addbutton(["class" => "btn btn-xs btn-block green", "data-show" => "job_complete", "data-key" => $src["job"]["job_id"]], "Tamamlandı");
                        }
                    }
                }
            }
        }
    }

}
