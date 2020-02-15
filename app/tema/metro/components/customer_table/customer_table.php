<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sidebar
 *
 * @author engin
 */
class customer_table extends component {

    public function render($parameter) {
        $this->set_component_name("customer_table");
        $this->make_component($parameter["type"]);
    }

    public function getdataAction($param = "") {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                //dnd($_POST);
                $start = sanitize($_POST["start"]);
                $end = sanitize($_POST["end"]);
                $direction = sanitize($_POST["direction"]);
                $component_name = sanitize($_POST["component_name"]);

                $ncustomer = new table_customer();
                $ncustomer->add_filter("customer_id");
                $ncustomer->select();
                $ncustomer->add_limit_start($start);
                $ncustomer->add_limit_end($end);
                $ncustomer->add_direction(strtoupper($direction));
                $ncustomer->add_condition("type", "automatic", "<>");
                $ncustomer->add_direction_by("customer_id","customer");

                //$ncustomer->add_join("customer_siteaccount", "customer_id");
                $customer_data = $ncustomer->get_alldata();
                $sub_tables = data::get_table_subtables("customer");
                $fixed_data = [];
                if (!empty($customer_data)) {
                    foreach ($customer_data as $dt) {
                        $primary_value = $dt->customer_id;
                        $sbfx = [];
                        $fixed_data[] = data::allInfo("customer", $primary_value);
                    }
                } else {
                    $fixed_data[] = "";
                }

                //dnd($fixed_data);
                //customer_id yerine table_id Kullanın
                $ncustomertotal = new table_customer();
                $ncustomertotal->set_count();
                $ncustomertotal->select();
                $ncustomertotal->add_condition("type", "automatic", "<>");
                $total_data = $ncustomertotal->get_alldata(true);


                $data["result"] = $fixed_data;
                $data["start"] = $start;
                $data["end"] = $end;

                $data["total"] = $total_data;
                $data["sonuc"] = true;
                $data["msg"] = "İşleminiz Başarılı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Veri Gönderiminde Bir Sorun Bulunmakta";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

    public function drawAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $total = $_POST["total"];
                $tabledata = $_POST["tabledata"];
                $start_item = $_POST["start"];
                $end_item = $_POST["end"];
                $update = $_POST["update"];
                $id = uniqid();
                $ntable = new pretable($tabledata, $id);
                $ntable_cl = [
                    "cloumb" => [
                        ["thead_title" => "Durum",
                            "thead_attr" => ["style" => "width:5%;font-size:12px;", "class" => "v-align-middle text-left", "title" => "Kullanıcı işlevsellik durumu"],
                            "tbody_varible" => "state",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "customer_state",
                        ],
                        ["thead_title" => "Kullanıcı Adı",
                            "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-left", "title" => "Kullanıcı Adı Soyadi"],
                            "tbody_varible" => "customer_name",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "customer_name",
                        ],
                        ["thead_title" => "mail adresi",
                            "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-left", "title" => "Kullanıcı Mail Adresi"],
                            "tbody_varible" => "parent_category",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "customer_email",
                        ],
                        ["thead_title" => "Kullanıcı Bilgisi",
                            "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-left", "title" => "Kullanıcı bilgileri"],
                            "tbody_varible" => "product_count",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "customer_meta",
                        ],
                        ["thead_title" => "Eylemler",
                            "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-left", "title" => "Sipariş Fiyatı"],
                            "tbody_varible" => "actions",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "actions",
                        ]
                    ]
                ];
                $ntable->set_table_info($ntable_cl);
                $ntable->set_control_class("customer_table_class");
                $ntable->set_component_name("customer_table");
                $ntable->set_table_header(true);
                $ntable->set_check_cloumb(true);
                $ntable->set_table_remove_button(true);
                $ntable->set_table_filters(true);

                $ntable->set_table_search_input(true);
                $ntable->set_multiple_search(false);
                $ntable->set_table_refresh_button(true);

                if ($update == "true") {
                    $ntable->set_table_update(true);
                }



                $ntable->set_table_footer(true);
                $ntable->set_error_message("Listenizde Ekli Kullanıcı Bulunmamaktadır");



                $ntable->set_show_item(($end_item - $start_item));
                $ntable->set_start_item($start_item);
                $ntable->set_end_item($end_item);
                $ntable->set_total_item($total);
                $table = $ntable->add_table(false);




                $data["component_name"] = "customer_table";
                $data["render"] = $table;
                $data["table_id"] = $ntable->get_table_key();
                $data["sonuc"] = true;
                $data["msg"] = "İşleminiz Başarılı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Veri Gönderiminde Bir Sorun Bulunmakta";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

    public function searchAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $q = input::santize($_REQUEST["q"]);
                $items = [];
                $ncustomer = new table_customer();
                $res = $ncustomer->search_customer($q);
                if (!empty($res)) {
                    foreach ($res as $r) {
                        $items[] = get_object_vars($r);
                    }
                    $data["items"] = $items;
                }
                $data["sonuc"] = true;
                $data["msg"] = "İşleminiz Başarılı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

    public function searchdataAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                //dnd($_POST);
                $keyword = sanitize($_POST["keyword"]);
                $component_name = sanitize($_POST["component_name"]);

                $ncustomer = new table_customer();
                $customer_data = $ncustomer->search_customer_data($keyword);
                //dnd($customer_data);
                $total_data = count($customer_data);
                $data["result"] = $customer_data;
                $data["start"] = $start;
                $data["end"] = $end;
                $data["total"] = $total_data;
                $data["sonuc"] = true;
                $data["msg"] = "İşleminiz Başarılı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Veri Gönderiminde Bir Sorun Bulunmakta";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

    public function show_customersAction($param = "") {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                //dnd($_POST);
                $start = sanitize($_POST["start"]);
                $end = sanitize($_POST["end"]);
                $direction = sanitize($_POST["direction"]);
                $component_name = sanitize($_POST["component_name"]);

                $ncustomer = new table_customer();
                $customer_data = $ncustomer->get_customers_info();
                //customer_id yerine table_id Kullanın
                //dnd($customer_data);
                $total_data = $ncustomer->get_customers_total();
                $data["result"] = $customer_data;
                $data["start"] = $start;
                $data["end"] = $end;
                $data["total"] = $total_data;
                $data["sonuc"] = true;
                $data["msg"] = "İşleminiz Başarılı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Veri Gönderiminde Bir Sorun Bulunmakta";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu alana bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

}
