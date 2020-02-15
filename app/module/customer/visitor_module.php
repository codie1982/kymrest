<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of visitor_module
 *
 * @author engin
 */
class visitor_module {

    public function __construct() {
        return true;
    }

    public static function new_visitor($ipno) {
//        $ncustomer = new table_customer();
//        $ncustomer->add_filter("customer_id");
//        $ncustomer->select();
//        $ncustomer->add_condition("visitor_ip", $ipno);
//        $ncustomer->add_limit_start(1);
//        $ncustomer->add_direction("DESC");
//        if ($customer_info = $ncustomer->get_alldata(true)) {
//            return $customer_info->customer_id;
//        } else {
//           
//        }

        data::add_post_data("customer_fields", "visitor_ip", $ipno);
        data::add_post_data("customer_fields", "visitor_id", rand(9999, 9999999));
        data::add_post_data("customer_fields", "visitor_referer", $_SERVER["HTTP_REFERER"]);
        data::add_post_data("customer_fields", "date", getNow());
        data::add_post_data("customer_fields", "public", 1);
        data::add_post_data("customer_fields", "sales", 1);
        data::add_post_data("customer_fields", "type", AUTOMATIC);
        data::add_post_data("customer_fields", "extention", $image_info["extention"]);
        data::add_post_data("customer_fields", "gallery_seccode", $gallery_seccode);
        data::add_post_data("customer_fields", "customer_code", rand(9999, 9999999));
        data::add_post_data("customer_fields", "date", getNow());
        data::add_post_data("customer_fields", "users_id", -1);
        $visitor_post = data::get_postdata();

        //TODO : Data integration İşleminin Yapılması gerekiyor
        $nprepare_customer_data = new prepare_customer_data();
        $control_module = $nprepare_customer_data->set_visitor_data($visitor_post);
        $customer_data = data::get_data($control_module, "customer");
        if ($customer_id = data::insert_data("customer", $customer_data)) {
            return $customer_id;
        } else {
            return false;
        }
    }

}
