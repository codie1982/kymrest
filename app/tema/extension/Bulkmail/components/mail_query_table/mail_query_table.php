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
class mail_query_table extends component {

    public function render($parameter) {
        $this->set_component_name("mail_query_table");
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

                $nbulkmail = new table_bulkmail();
                $nbulkmail->select();
                $nbulkmail->add_limit_start($start);
                $nbulkmail->add_limit_end($end);
                $nbulkmail->add_direction($direction);
                $nbulkmail->add_condition("send", 0);
                $mail_query = $nbulkmail->get_alldata();

                $ntsend_mail = new table_bulkmail();
                $ntsend_mail->set_count();
                $ntsend_mail->select();
                $tt = $ntsend_mail->get_alldata(true);

                $data["start"] = $start;
                $data["end"] = $end;
                if ($mail_query) {
                    $data["result"] = $mail_query;
                    $data["total"] = $tt;
                } else {
                    $data["result"] = 0;
                    $data["total"] = 0;
                }
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
                $cloumb = [
                    "cloumb" => [
                        ["thead_title" => "Yayın",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Mail yayın durumu"],
                            "tbody_varible" => "mail_public",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "mail_public",
                        ],
                        ["thead_title" => "Mail Adresi",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Mail Adresi"],
                            "tbody_varible" => "mail_adres",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "mail_adres",
                        ],
                        ["thead_title" => "İsim Soyisim",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Kullanıcı İsim Soyismi"],
                            "tbody_varible" => "mail_subject",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "namelastname",
                        ],
                        ["thead_title" => "Mail İçeriği",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "Mail Konusu"],
                            "tbody_varible" => "mail_subject",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "mail_subject",
                        ],
                        ["thead_title" => "Kuyruklama Tarihi",
                            "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center", "title" => "mail görüntüleme tarihi"],
                            "tbody_varible" => "mail_query_date",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "mail_query_date",
                        ],
                        ["thead_title" => "Eylemler",
                            "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-left", "title" => "Sipariş Fiyatı"],
                            "tbody_varible" => "actions",
                            "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                            "function" => "actions",
                        ]
                    ]
                ];
                $ntable->set_table_info($cloumb);
                $ntable->set_control_class("mail_query_table_class");
                $ntable->set_component_name("mail_query_table");
                $ntable->set_table_header(true);

                $ntable->set_check_cloumb(true);
                $ntable->set_table_remove_button(true);
                $ntable->set_table_filters(false);

                //$ntable->add_table_filter("En Çok Satılan Ürünleri Göster", "fa fa-pencil", "show_best_products");

                $ntable->set_table_search_input(true);
                $ntable->set_multiple_search(false);
                $ntable->set_table_refresh_button(true);

                if ($update == "true") {
                    $ntable->set_table_update(true);
                }

                $ntable->set_table_footer(true);
                $ntable->set_error_message("Mail Kuyruğunda bir mail gönderimi bulunmuyor.");

                $ntable->set_show_item(($end_item - $start_item));
                $ntable->set_start_item($start_item);
                $ntable->set_end_item($end_item);
                $ntable->set_total_item($total);

                $data["component_name"] = "mail_query_table";
                $data["render"] = $ntable->add_table(false);
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

}
